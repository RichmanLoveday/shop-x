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

                <div class="row mb-30">
                    <div class="col-12">
                        <div class="toggle_info">
                            <span>
                                <i class="fi-rs-user mr-10"></i>
                                <span class="text-muted font-lg">Already have an account?</span>
                                <a href="login.html">Click here to login</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="wsus__shipping_address mb_40">
                    <h4>Billing Address
                        <a href="#loginform" data-bs-toggle="collapse" class="collapsed font-lg" aria-expanded="false">add
                            new address</a>
                    </h4>

                    <div class="panel-collapse collapse login_form" id="loginform">
                        <div class="panel-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Name ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" placeholder="Email ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Phone ">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea placeholder="Address" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-md" name="login">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="option1">
                                    <label class="form-check-label" for="inlineRadio1">98 Winn St, Woburn, MA
                                        01801,USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">98 Winn St, Woburn, MA 01801,
                                        USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio3" value="option3">
                                    <label class="form-check-label" for="inlineRadio3">98 Winn St, Woburn, MA 01801,
                                        USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-30">
                    <form method="post">
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress">
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
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio1b" value="option1">
                                                <label class="form-check-label" for="inlineRadio1b">98 Winn St,
                                                    Woburn, MA
                                                    01801,USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio2b" value="option2">
                                                <label class="form-check-label" for="inlineRadio2b">98 Winn St,
                                                    Woburn, MA 01801,
                                                    USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio3b" value="option3">
                                                <label class="form-check-label" for="inlineRadio3b">98 Winn St,
                                                    Woburn, MA 01801,
                                                    USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
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
                </div>

            </div>
            <div class="col-xl-4">
                <div class="wsus__billing_summary">
                    <h4>Billing Summery</h4>
                    <h5 class="vendor_name">Vendor Name</h5>
                    <ul class="wsus__billing_product">
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-2-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-3-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                    </ul>
                    <h5 class="vendor_name">Vendor Name</h5>
                    <ul class="wsus__billing_product">
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-1-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-2-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-3-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-1-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                    </ul>
                    <div class="wsus__total_price">

                        <h4 class="mb-3">Shipping Method</h4>

                        <div class="shipping-methods">

                            @foreach ($shippingMethods as $rule)
                                <label
                                    class="shipping-option card mb-2 cursor-pointer {{ !is_null($shipping) && $shipping['id'] == $rule->id ? 'active' : '' }}">
                                    <div class="card-body d-flex justify-content-between align-items-center">

                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input class="form-check-input shipping-rule" type="radio"
                                                {{ !is_null($shipping) && $shipping['id'] == $rule->id ? 'checked' : '' }}
                                                name="shipping_rule_id" value="{{ $rule->id }}"
                                                data-charge="{{ $rule->charge }}" id="shipping_{{ $rule->id }}">

                                            <div>
                                                <h6 class="mb-0">
                                                    {{ $rule->name }}
                                                </h6>

                                                <small class="text-muted">
                                                    {{ $rule->type->label() }}
                                                    @if ($rule->minimum_amount)
                                                        • Min order: ${{ number_format($rule->minimum_amount, 2) }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        <div>
                                            <strong class="text-brand">
                                                ${{ number_format($rule->charge, 2) }}
                                            </strong>
                                        </div>

                                    </div>
                                </label>
                            @endforeach
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {

                $('.shipping-rule').on('change', function() {

                    $('.shipping-option').removeClass('active');
                    $(this).closest('.shipping-option').addClass('active');

                    let shippingCharge = parseFloat($(this).data('charge'));

                    let subTotal = {{ $cartSubTotal }};
                    let discount = {{ $appliedCoupon['discount'] ?? 0 }};

                    let total = subTotal - discount + shippingCharge;

                    $('#shippingCharge').text('$' + shippingCharge.toFixed(2));
                    $('#grandTotal').text('$' + total.toFixed(2));


                    // send request to ajax to save shipping method and get calculated items for this cart
                    let id = $(this).val();
                    console.log(id);
                    $.ajax({
                        url: route('checkout.shipping', [id]),
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

            });
        </script>
    @endpush
@endsection
