@extends('frontend.layout.app')
@section('contents')
    @push('styles')
        <style>
            .shipping-option {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                transition: all .2s ease;
                cursor: pointer;
            }

            .shipping-option:hover {
                border-color: var(--colorSecondary);
                box-shadow: 0 4px 20px rgba(0, 0, 0, .05);
            }

            .shipping-option.active {
                border-color: var(--colorSecondary);
                background: #fff5e9;
            }

            /* Make radio/checkbox use theme color */
            .shipping-option .form-check-input {
                width: 18px;
                height: 18px;
                cursor: pointer;
                border: 2px solid #ccc;
            }

            /* when checked */
            .shipping-option .form-check-input:checked {
                background-color: var(--colorSecondary);
                border-color: var(--colorSecondary);
            }

            /* focus state */
            .shipping-option .form-check-input:focus {
                box-shadow: 0 0 0 0.2rem rgba(var(--colorSecondary-rgb, 59, 183, 126), 0.25);
                border-color: var(--colorSecondary);
            }


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
        </style>
    @endpush

    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => '/checkout', 'label' => 'Checkout']]" />

    <div class="container mb-60 mt-60">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Checkout</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand">3</span> products in your cart</h6>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="wsus__shipping_address mb_40">
                    <h4>Billing Address

                    </h4>

                    <div class="row">
                        @foreach ($addresses as $address)
                            <x-frontend.billing-address :address="$address" :defaultAddress="true"
                                class='col-md-6 col-lg-4 col-xl-4' />
                        @endforeach
                    </div>
                </div>

                <div class="row mt-30">
                    <form method="post">
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input ship_to_different_address" type="checkbox"
                                            name="checkbox" id="differentaddress">
                                        <label class="form-check-label label_info" data-bs-toggle="collapse"
                                            data-target="#collapseAddress" href="#collapseAddress"
                                            aria-controls="collapseAddress" for="differentaddress"><span>Ship to a
                                                different address?</span></label>
                                    </div>
                                </div>
                            </div>
                            <div id="collapseAddress" class="different_address collapse in">
                                <h4>Shipping Details</h4>
                                <div class="row mb-50">

                                    @foreach ($addresses as $address)
                                        <x-frontend.billing-address :address="$address" class='col-md-6 col-lg-4 col-xl-4' />
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- <div class="row">
                    <div class="col-xl-12">
                        <ul class="wsus__checkout_form_btn">
                            <li>
                                <a href="cart.html" class="btn w-100 hover-up">Cart List</a>
                            </li>
                            <li>
                                <a href="payment.html" class="btn w-100 hover-up">Payment</a>
                            </li>
                        </ul>
                    </div>
                </div> --}}

            </div>
            <div class="col-xl-4">
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
                        @php
                            if (!is_null($appliedCoupon)) {
                                $couponValue = $appliedCoupon['coupon_value'];
                                $couponType = $appliedCoupon['coupon_type'];
                                $couponInfo =
                                    $couponType == 'Fixed' ? "({$couponType})" : "({$couponValue} {$couponType})";
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
                    <h5>Total <span class="cart_total">$ {{ number_format($total, 2) }}</span></h5>


                    <div class="my-4">
                        <button id="make-payment-button" href="payment.html" class="btn w-100 hover-up">Payment</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {

                $('.shipping-method').on('change', function() {

                    $('.shipping-option').removeClass('active');
                    $(this).closest('.shipping-option').addClass('active');

                    let shippingCharge = parseFloat($(this).data('charge'));

                    let subTotal = {{ $cartSubTotal }};
                    let discount = {{ $appliedCoupon['discount'] ?? 0 }};

                    let total = subTotal - discount + shippingCharge;

                    $('#shippingCharge').text('$' + shippingCharge.toFixed(2));
                    $('#grandTotal').text('$' + total.toFixed(2));


                    // send request to ajax to save shipping method and get calculated items for this cart
                    let rule_id = $(this).data('ruleId');
                    let zone_id = $(this).data('zoneId');

                    // console.log(id);
                    $.ajax({
                        url: route('checkout.shipping', [rule_id, zone_id]),
                        method: "GET",
                        success: function(res) {
                            let data = res.data;

                            if (res.status) {
                                let shipping_charge = new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(data.shipping_charge);


                                let total = new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(data.total);

                                $('.cart_total').text(`$${total}`);
                                $('.shipping_charge').text(`$${shipping_charge}`);
                            }
                        }
                    });
                });


                // Remove coupon
                $(document).on('click', '.remove-coupon', function(e) {
                    e.preventDefault();

                    const btn = $(this);

                    // prevent double click
                    if (btn.hasClass('loading')) return;

                    const btnHtml = btn.html();

                    $.ajax({
                        url: route('cart.remove-coupon'),
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },

                        beforeSend: function() {
                            btn.addClass('loading')
                                .css({
                                    'pointer-events': 'none',
                                    'opacity': '0.6'
                                })
                                .html('<i class="fi-rs-loading fa-spin"></i>');
                        },

                        success: function(res) {
                            if (res.status) {
                                let cart_sub_total = new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(res.cart_sub_total);

                                let total = new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }).format(res.total);

                                $('.cart_sub_total').text(`$${cart_sub_total}`);
                                $('.coupon-info').html(`Discount <span>$0.00</span>`);
                                $('.discount-info').text('$0.00');
                                $('.cart_total').text(`$${total}`);

                                // remove coupon UI completely
                                btn.closest('.show_coupon').remove();

                                notyf.success(res.message);
                            } else {
                                resetButton();
                            }
                        },

                        error: function(xhr) {
                            notyf.error(xhr.responseJSON.message);
                            resetButton();
                        }
                    });

                    function resetButton() {
                        btn.removeClass('loading')
                            .css({
                                'pointer-events': 'auto',
                                'opacity': '1'
                            })
                            .html(btnHtml);
                    }
                });



                $('.address-card').on('click', function(e) {
                    // ignore edit/delete clicks
                    if ($(e.target).closest('a').length) return;

                    let id = $(this).data('id');

                    let radio = $(this).find('.billing_address');

                    radio.prop('checked', true).trigger('change');

                });

                // update default address
                $('.billing_address').on('change', function() {

                    let id = $(this).data('id');
                    console.log(id);

                    $.ajax({
                        url: route('address.set-default', [id]),
                        method: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(res) {
                            if (res.status) {
                                notyf.success(res.message || 'Default address updated');
                            } else {
                                notyf.error(res.message || 'Something went wrong');
                            }
                        },

                        error: function() {
                            notyf.error('Failed to update address');
                        }
                    });

                });

                // make payment button
                $('#make-payment-button').on('click', function() {
                    let error = false;
                    // check if shipping method is selected
                    if (!$('.shipping-method:checked').length > 0) {
                        notyf.error("Please select a shipping method");
                        error = true;
                    }

                    // check if billing address method is selected
                    if (!$('.billing_address').length > 0) {
                        notyf.error('Please select a shipping address');
                        error = true;
                    }


                    // check if shipping method is selected
                    if (!$('.ship_to_different_address').is(':checked') && (!$('.shipping_address:checked')
                            .length > 0)) {
                        notyf.error("Please select a shipping address");
                        error = true;
                    }


                    // send data to backend
                    let shippingMethod = $('.shipping-method:checked').data('rule-id');
                    let zoneId = $('.shipping-method:checked:checked').data('zone-id')
                    let billingAddress = $('.billing_address:checked').val();
                    let shippingAddress = $('.ship_to_different_address').is(':checked') ? $(
                        '.shipping_address:checked').val() : null;

                    if (!error) {
                        $.ajax({
                            url: route("checkout.billing-info.store"),
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                shipping_method_id: shippingMethod,
                                zone_id: zoneId,
                                billing_address_id: billingAddress,
                                shipping_address_id: shippingAddress,
                            },
                            beforeSend: function() {},
                            success: function() {},
                        })
                    }
                });
            });
        </script>
    @endpush
@endsection
