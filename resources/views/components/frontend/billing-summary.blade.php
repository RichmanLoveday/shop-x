   @props([
       'appliedCoupon',
       'cartItems',
       'shippingMethods' => null,
       'cartSubTotal',
       'total',
       'shipping',
       'class' => 'col-xl-4',
       'checkout' => true,
   ])

   @push('styles')
       <style>
           .checkout-store-card {
               border: 1px solid #eee;
               border-radius: 12px;
               padding: 15px;
               background: #fff;
           }

           .store-header {
               background: #fff5e9;
               /* solid color instead of gradient */
               color: var(--colorSecondary);
               padding: 10px 14px;
               font-weight: 600;
               border-radius: 8px;
               margin-bottom: 15px;
               font-size: 16px;
           }

           .custom-billing-list {
               max-height: 320px;
               overflow-y: auto;
               padding-right: 5px;
           }

           .billing-product-item {
               display: flex;
               gap: 14px;
               margin-bottom: 18px;
               align-items: flex-start;
           }

           .product-thumb {
               width: 80px;
               height: 80px;
               min-width: 80px;
               border-radius: 10px;
               overflow: hidden;
               position: relative;
               border: 1px solid #eee;
           }

           .product-thumb img {
               width: 100%;
               height: 100%;
               object-fit: cover;
           }

           /* grayscale image */
           .product-thumb.out-stock img {
               filter: grayscale(100%);
               opacity: .7;
           }

           /* out-of-stock overlay */
           .stock-overlay {
               position: absolute;
               inset: 0;
               background: linear-gradient(rgba(0, 0, 0, .2),
                       rgba(0, 0, 0, .65));
               color: white;
               font-size: 11px;
               font-weight: 700;
               display: flex;
               justify-content: center;
               align-items: center;
               z-index: 10;
               text-transform: uppercase;
               letter-spacing: 1px;
           }

           .product-info {
               flex: 1;
           }

           .product-name {
               display: block;
               font-weight: 600;
               color: #222;
               line-height: 1.4;
               margin-bottom: 6px;
           }

           .product-name:hover {
               color: var(--colorSecondary);
           }

           .variant-badge {
               display: inline-block;
               background: #f3f4f6;
               color: #666;
               padding: 3px 8px;
               border-radius: 20px;
               font-size: 11px;
               margin-bottom: 6px;
           }

           .product-price {
               font-weight: 600;
               color: var(--colorSecondary);
           }

           .qty {
               color: #666;
               font-weight: 400;
           }

           .store-subtotal {
               border-top: 1px solid #eee;
               padding-top: 12px;
               text-align: right;
               font-size: 15px;
           }

           .selected-shipping-method {
               border: 1px solid #eee;
               border-radius: 12px;
               padding: 14px;
               background: #fff5e9;
           }
       </style>
   @endpush

   <div class="{{ $class }}">
       <div class="wsus__billing_summary">
           <h4 class="mb-3">Billing Summary</h4>

           @foreach ($cartItems as $store)
               <div class="checkout-store-card mb-4">

                   {{-- Store Name --}}
                   <div class="store-header">
                       {{ $store['store']['name'] }}
                   </div>

                   <ul class="wsus__billing_product custom-billing-list">
                       @foreach ($store['items'] as $item)
                           @php
                               $variantData = $item['variant_or_product_and_stock'];
                               $price = $variantData['price'];
                               $qty = $item['qty'];
                               $variantName = $item['variant']?->name;
                               $isOutOfStock = !$variantData['in_stock'];
                               $isInactive = !$variantData['is_active'];
                           @endphp

                           <li class="billing-product-item j">

                               {{-- PRODUCT IMAGE --}}
                               <a href="{{ route('products.show', $item['slug']) }}"
                                   class="product-thumb {{ $isOutOfStock ? 'out-stock' : '' }}">

                                   <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="img-fluid">

                                   @if ($isOutOfStock || $isInactive)
                                       <div class="stock-overlay">
                                           Out of Stock
                                       </div>
                                   @endif
                               </a>

                               {{-- PRODUCT INFO --}}
                               <div class="product-info p-2">
                                   <a href="{{ route('products.show', $item['slug']) }}" class="product-name">
                                       {{ Str::limit($item['name'], 50, '....') }}
                                   </a>

                                   @if ($variantName)
                                       <small class="variant-badge">
                                           {{ $variantName }}
                                       </small>
                                   @endif

                                   <div class="product-price">
                                       ${{ number_format($price, 2) }}
                                       <span class="qty">× {{ $qty }}</span>
                                   </div>
                               </div>
                           </li>
                       @endforeach
                   </ul>

                   {{-- STORE SUBTOTAL --}}
                   <div class="store-subtotal">
                       Subtotal:
                       <strong>${{ number_format($store['subtotal'], 2) }}</strong>
                   </div>
               </div>
           @endforeach
           <div class="wsus__total_price">

               @if ($checkout)
                   <h4 class="mb-3">Shipping Method</h4>

                   <div class="shipping-methods">

                       @if (!empty($shippingMethods['shipping']['shipping_rules']))
                           @foreach ($shippingMethods['shipping']['shipping_rules'] as $rule)
                               <label
                                   class="shipping-option card mb-2 cursor-pointer {{ !is_null($shipping) && $shipping['id'] == $rule['id'] ? 'active' : '' }}">

                                   <div class="card-body d-flex justify-content-between align-items-center">

                                       <div class="form-check d-flex align-items-center gap-2">

                                           <input class="form-check-input shipping-method" type="radio"
                                               name="shipping_rule_id" data-rule-id="{{ $rule['id'] }}"
                                               data-zone-id="{{ 3 }}"
                                               data-charge="{{ $rule['final_charge'] }}"
                                               id="shipping_{{ $rule['id'] }}"
                                               {{ !is_null($shipping) && $shipping['id'] == $rule['id'] ? 'checked' : '' }}>

                                           <div>
                                               <h6 class="mb-0">
                                                   {{ $rule['name'] }}
                                               </h6>

                                               <small class="text-muted">
                                                   {{ $rule['type'] }}

                                                   @if (!empty($rule['minimum_amount']))
                                                       • Min order:
                                                       ${{ number_format($rule['minimum_amount'], 2) }}
                                                   @endif
                                               </small>
                                           </div>
                                       </div>

                                       <div>
                                           <strong class="text-brand">
                                               ${{ number_format($rule['final_charge'], 2) }}
                                           </strong>
                                       </div>

                                   </div>
                               </label>
                           @endforeach
                       @else
                           <div class="alert alert-warning">
                               {{ $shippingMethods['shipping_error'] ?? 'Items cannot be shipped to your current address.' }}
                           </div>
                       @endif
                   </div>
               @endif

               @php
                   if (!is_null($appliedCoupon)) {
                       $couponValue = $appliedCoupon['coupon_value'];
                       $couponType = $appliedCoupon['coupon_type'];
                       $couponInfo = $couponType == 'Fixed' ? "({$couponType})" : "({$couponValue} {$couponType})";
                   }
               @endphp

               <hr>
               {{-- <form method="post" class="apply-coupon mb-10">
                            <input type="text" placeholder="Enter Coupon Code...">
                            <button class="btn  btn-md" name="login">Apply Coupon</button>
                        </form> --}}

               @if (!is_null($appliedCoupon))
                   <div class="show_coupon">
                       <p>Coupon code
                           <span>#{{ $appliedCoupon['code'] }}</span>
                           <a href="javascript:void(0);" class="remove-coupon">
                               <i class="fi fi-rs-trash"></i>
                           </a>
                       </p>
                   </div>
               @endif

               <h3>Sub Total <span class="cart_sub_total">$ {{ number_format($cartSubTotal, 2) }}</span></h3>
               <p>Shipping Charge <span class="shipping_charge">$
                       {{ !is_null($shipping) ? number_format($shipping['charge'], 2) : '0.00' }}</span></p>
               <p class="coupon-info">Discount {{ $couponInfo ?? '' }}
                   <span>${{ number_format($appliedCoupon['discount'] ?? 0.0, 2) }}</span>
               </p>
               <p>Tax <span>00.00</span></p>
           </div>
           @if (!is_null($shipping) && !$checkout)
               <div class="selected-shipping-method mt-3">
                   <div class="d-flex justify-content-between align-items-center">
                       <div>
                           <h6 class="mb-0">
                               {{ $shipping['name'] }}
                           </h6>

                           <small class="text-muted">
                               Shipping Method
                           </small>
                       </div>

                       <strong class="text-brand">
                           ${{ number_format($shipping['charge'], 2) }}
                       </strong>
                   </div>
               </div>
           @endif
           <h5>Total <span class="cart_total">$ {{ number_format($total, 2) }}</span></h5>

           @if ($checkout)
               <div class="my-4">
                   <button id="make-payment-button" href="payment.html" class="btn w-100 hover-up">Payment</button>
               </div>
           @endif

       </div>
   </div>
