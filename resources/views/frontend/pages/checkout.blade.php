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
            <x-frontend.billing-summary :cartItems="$cartItems" :shippingMethods="$shippingMethods" :shipping="$shipping" :appliedCoupon="$appliedCoupon"
                :cartSubTotal="$cartSubTotal" :total="$total" />
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
                            success: function() {
                                window.location.href = route('payment.index')
                            },
                        })
                    }
                });
            });
        </script>
    @endpush
@endsection
