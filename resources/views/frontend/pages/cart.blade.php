@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => '/cart', 'label' => 'Cart']]" />

    <div class="container mb-60 mt-55">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex flex-wrap justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand cart_count">{{ $cartCount }}</span> products in
                        your cart</h6>
                    <h6 class="text-body"><a href="javascript:void(0)" id="delete-selected" class="text-muted"><i
                                class="fi-rs-trash mr-5"></i>Clear
                            Cart</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="{{ $cartItems->isEmpty() ? 'col-lg-12' : 'col-lg-8' }}">
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">
                                    <input class="form-check-input all_cart_checkbox" type="checkbox" name="checkbox"
                                        id="exampleCheckbox11" value="">
                                    <label class="form-check-label" for="exampleCheckbox11"></label>
                                </th>
                                <th scope="col" colspan="2">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" class="end">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="cart_table_container">
                            <x-frontend.cart-item-component :cartItems="$cartItems" />
                        </tbody>
                    </table>
                </div>
                <div class="divider-2 mb-30"></div>
                <div class="cart-action d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                </div>
            </div>
            <div class="col-lg-4" style="display: {{ $cartItems->isEmpty() ? 'none' : 'block' }}">

                <div class="p-40">
                    <h4 class="mb-10">Apply Coupon</h4>
                    <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</p>
                    <form action="#" class="coupon-form">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <input class="font-medium mr-15 coupon coupon-input" {{ $appliedCoupon ? 'disabled' : '' }}
                                value="{{ $appliedCoupon['code'] ?? '' }}" name="coupon" placeholder="Enter Your Coupon">
                            @if (!is_null($appliedCoupon))
                                <button data-id="{{ $appliedCoupon['id'] }}" type="button"
                                    class="btn btn-danger remove-coupon"><i class="fi-rs-cross mr-10"></i>Remove</button>
                            @else
                                <button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="border p-md-4 cart-totals ml-30">
                    <div class="table-responsive">
                        <table class="table no-border">
                            @php
                                if (!is_null($appliedCoupon)) {
                                    $couponValue = $appliedCoupon['coupon_value'];
                                    $couponType = $appliedCoupon['coupon_type'];
                                    $couponInfo =
                                        $couponType == 'Fixed' ? "({$couponType})" : "({$couponValue} {$couponType})";
                                }
                            @endphp
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end"><span
                                                class="cart_sub_total">${{ number_format($appliedCoupon['cart_sub_total'] ?? $cartSubTotal, 2) }}</span>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Discount <span
                                                class="coupon-info">{{ $couponInfo ?? '' }}</span></h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end discount-info">
                                            ${{ $appliedCoupon['discount'] ?? 0.0 }}
                                        </h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Estimate for</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">United Kingdom</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total </h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end"><span
                                                class="cart_total">{{ "$" . number_format($total, 2) }}</span>
                                        </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn w-100">Proceed To CheckOut<i
                            class="fi-rs-sign-out ml-15"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '.qty-up', function(event) {
                event.preventDefault();
                var input = $(this).siblings('.qty-val');
                var qtyval = parseInt(input.val(), 10);

                qtyval = qtyval + 1;
                input.val(qtyval);
                input.change();
            });

            $(document).on('click', '.qty-down', function(event) {
                event.preventDefault();
                var input = $(this).siblings('.qty-val');
                var qtyval = parseInt(input.val(), 10);

                qtyval = Math.max(1, qtyval - 1);
                input.val(qtyval);
                input.change();
            });


            $(document).on('change', '.qty-val', function() {
                let qty = $(this).val();
                let id = $(this).data('id');
                let productType = $(this).data('product-type');

                $.ajax({
                    url: route('cart.update'),
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id,
                        qty,
                        productType,
                    },
                    beforeSend: function() {},
                    success: function(res) {
                        if (res.status) {
                            // check if coupon is applied
                            if (res.appliedCoupon) {
                                var couponInfo = res.appliedCoupon.coupon_type == 'Fixed' ?
                                    `(${ res.appliedCoupon.coupon_type})` :
                                    `(${res.appliedCoupon.coupon_value} ${res.appliedCoupon.coupon_type})`;
                            }

                            let cart_sub_total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(res.cart_sub_total);

                            let total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(res.total);



                            $('#cart_table_container').html('').html(res.html);
                            $('.coupon-info').text(couponInfo ?? '');
                            $('.discount-info').text(`$${res.appliedCoupon?.discount ?? 0.00}`);
                            $('.cart_sub_total').text(`$${cart_sub_total}`);
                            $('.cart_total').text(`$${total}`);

                            notyf.success(res.message);
                        }
                    },
                    error: function(error) {
                        let res = error.responseJSON;
                        notyf.error(res.message);
                    },
                })
            });

            // delete item from cart
            $(document).on('click', '.delete-cart-item', function(event) {
                event.preventDefault();

                let button = $(this);
                let id = button.data('id');

                $.ajax({
                    url: route('cart.remove', id),
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },

                    beforeSend: function() {
                        button
                            .prop('disabled', true)
                            .html('<i class="fa-solid fa-spinner fa-spin"></i>');
                    },

                    success: function(res) {
                        if (res.status) {
                            if (res.appliedCoupon) {
                                var couponInfo = res.appliedCoupon.coupon_type == 'Fixed' ?
                                    `(${ res.appliedCoupon.coupon_type})` :
                                    `(${res.appliedCoupon.coupon_value} ${res.appliedCoupon.coupon_type})`;
                            }

                            let cart_sub_total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(res.cart_sub_total);

                            let total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(res.total);



                            $('#cart_table_container').html('').html(res.html);
                            $('.coupon-info').text(couponInfo ?? '');
                            $('.discount-info').text(`$${res.appliedCoupon?.discount ?? 0.00}`);
                            $('.cart_sub_total').text(`$${cart_sub_total}`);
                            $('.cart_total').text(`$${total}`);
                            $('.cart_icon').text(res.cart_count);
                            $('.cart_count').text(res.cart_count);

                            notyf.success(res.message);
                        }
                    },

                    error: function(error) {
                        let res = error.responseJSON;
                        notyf.error(res.message);
                    },

                    complete: function() {
                        button.prop('disabled', false);
                    }
                });
            });

            // bulk delete items from cart
            $(document).on('click', '#delete-selected', function(event) {
                let button = $(this);
                let html = button.html();
                console.log(button)
                let selected = [];

                $('.cart-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });

                if (selected.length === 0) {
                    notyf.error('Please select cart items');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: route('cart.bulk-delete'),
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                cart_ids: selected
                            },

                            beforeSend: function() {
                                button
                                    .prop('disabled', true)
                                    .html(
                                        '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...'
                                    );
                            },

                            success: function(res) {
                                if (res.status) {
                                    if (res.appliedCoupon) {
                                        var couponInfo = res.appliedCoupon
                                            .coupon_type == 'Fixed' ?
                                            `(${ res.appliedCoupon.coupon_type})` :
                                            `(${res.appliedCoupon.coupon_value} ${res.appliedCoupon.coupon_type})`;
                                    }

                                    let cart_sub_total = new Intl.NumberFormat(
                                        'en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        }).format(res.cart_sub_total);

                                    let total = new Intl.NumberFormat('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }).format(res.total);



                                    $('#cart_table_container').html('').html(res.html);
                                    $('.coupon-info').text(couponInfo ?? '');
                                    $('.discount-info').text(
                                        `$${res.appliedCoupon?.discount ?? 0.00}`);
                                    $('.cart_sub_total').text(`$${cart_sub_total}`);
                                    $('.cart_total').text(`$${total}`);
                                    $('.cart_icon').text(res.cart_count);
                                    $('.cart_count').text(res.cart_count);

                                    // fire sweet alert
                                    Swal.fire(
                                        'Deleted!',
                                        res.message,
                                        'success'
                                    ).then(() => {
                                        $('#cart_table_container').html(res
                                            .html);
                                        $('.cart_sub_total').text(
                                            `$${cart_sub_total}`);
                                    });
                                }
                            },

                            error: function(xhr) {
                                notyf.error(xhr.responseJSON.message);
                            },

                            complete: function() {
                                button
                                    .prop('disabled', false)
                                    .html(html)
                            }
                        });
                    }
                });

            });

            // select all checkboxes
            $(document).on('change', '.all_cart_checkbox', function() {
                $('.cart-checkbox').prop('checked', $(this).prop('checked'));
            });


            $('.coupon-form').on('submit', function(event) {
                event.preventDefault();

                const form = $(this);
                const data = form.serialize();
                const btnHtml = form.find('.btn').html();

                $.ajax({
                    url: route('cart.apply-coupon'),
                    method: "POST",
                    data: data,
                    beforeSend: function() {
                        form.find('.btn')
                            .addClass('disabled')
                            .html('Applying...');
                    },
                    success: function(res) {
                        if (res.status) {
                            const data = res.data;
                            const removeCouponBtn =
                                `<button data-id="${data.id}" type="button"
                                    class="btn btn-danger remove-coupon"><i class="fi-rs-cross mr-10"></i>Remove</button>`;

                            let cart_sub_total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(data.cart_sub_total);

                            let total = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(data.total);

                            let couponInfo = data.coupon_type == 'Fixed' ?
                                `(${ data.coupon_type})` :
                                `(${data.coupon_value} ${data.coupon_type})`;

                            form.find('.btn').replaceWith(removeCouponBtn);
                            $('.coupon-input').prop('disabled', true);
                            $('.cart_sub_total').text(`$${cart_sub_total}`);
                            $('.coupon-info').text(couponInfo);
                            $('.discount-info').text(`$${data.discount}`);
                            $('.cart_total').text(`$${total}`);

                            notyf.success(res.message);
                        }
                    },
                    error: function(xhr) {
                        form.find('.btn').removeClass('disabled').html(btnHtml);
                        notyf.error(xhr.responseJSON.message);
                    },
                });
            });

            // Remove coupon
            $(document).on('click', '.remove-coupon', function(event) {
                event.preventDefault();
                const btn = $(this);
                const btnHtml = btn.html();

                // Define the Apply button markup exactly matching your Blade layout
                const applyCouponBtn =
                    `<button class="btn"><i class="fi-rs-label mr-10"></i>Apply</button>`;

                $.ajax({
                    url: route('cart.remove-coupon'),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    beforeSend: function() {
                        // Note: For state flags like disabled, .prop() is preferred over .attr()
                        btn.prop('disabled', true).html('Removing...');
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

                            $('#cart_table_container').html(res.html);
                            $('.cart_sub_total').text(`$${cart_sub_total}`);

                            // 1. Enable the input field and clear its value
                            $('.coupon-input').prop('disabled', false).val('');

                            $('.coupon-info').text('');
                            $('.discount-info').text('$0.00');
                            $('.cart_total').text(`$${total}`);

                            // 2. Replace the active Remove button with the Apply button
                            btn.replaceWith(applyCouponBtn);

                            notyf.success(res.message);
                        } else {
                            // Revert button state if server validation fails despite successful HTTP request
                            btn.prop('disabled', false).html(btnHtml);
                        }
                    },
                    error: function(xhr) {
                        notyf.error(xhr.responseJSON.message);
                        // Revert button state on error
                        btn.prop('disabled', false).html(btnHtml);
                    }
                });
            });

        });
    </script>
@endpush
