@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('vendor.kyc.index'), 'label' => 'Kyc Verification']]" />
    <div class="container mt-70 mb-60">
        <div class="row">
            <div class="col-lg-3 col-xxl-2 primary-sidebar sticky-sidebar">

                <div class="sidebar_filter d-lg-none">filter</div>

                @include('frontend.pages.partials.product-page-sidebar')

            </div>
            <div class="col-lg-9 col-xxl-10">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">29</strong> items for you!</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">50</a></li>
                                    <li><a href="#">100</a></li>
                                    <li><a href="#">150</a></li>
                                    <li><a href="#">200</a></li>
                                    <li><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">Featured</a></li>
                                    <li><a href="#">Price: Low to High</a></li>
                                    <li><a href="#">Price: High to Low</a></li>
                                    <li><a href="#">Release Date</a></li>
                                    <li><a href="#">Avg. Rating</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid">
                    @forelse ($products as $product)
                        <x-frontend.product-card :product="$product" />
                    @empty
                        <p>No Product Found</p>
                    @endforelse
                </div>
                <!--product grid-->
                <div class="pagination-area">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.add_to_cart').on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const productId = button.data('id');
                const type = button.data('type');
                const variants = button.data('variants');
                const quantity = 1;

                if (variants.length != 0) {
                    quickView(button, type, productId);
                } else {
                    addToCart(button, productId, type, quantity);
                }

                // store original content

            });

            // add to cart btn
            $(document).on('click', '.add_to_cart_btn', function(e) {
                e.preventDefault();

                const button = $(this);
                const productId = button.data('id');
                const type = button.data('type');
                const variantId = $('#selected_variant').val();
                const quantity = $('.qty-val').val();

                addToCart(button, productId, type, quantity, variantId);
            });


            $('.quick_view').on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const productId = button.data('id');
                const type = button.data('type');

                quickView(button, type, productId);

            });


            function addToCart(button, productId, type, quantity, variant = null, options = []) {
                const originalHtml = button.html();

                // send ajax request to add to card
                $.ajax({
                    url: route('cart.add'),
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        type: type,
                        variant: variant,
                        quantity: quantity,
                        option: options,
                    },
                    beforeSend: function() {
                        button.prop('disabled', true);
                        button.html(`
                            <i class="fa fa-spinner fa-spin mr-5"></i> Loading...
                        `);
                    },

                    success: function(res) {
                        if (res.status) {
                            notyf.success(res.message);

                            button.prop('disabled', false);
                            button.html(originalHtml);
                        }
                    },

                    error: function(error) {
                        let res = error.responseJSON;
                        notyf.error(res.message);

                        button.prop('disabled', false);
                        button.html(originalHtml);
                    },

                    complete: function() {
                        button.prop('disabled', false);
                        button.html(originalHtml);
                    }

                });
            }

            function quickView(button, type, productId) {
                const originalHtml = button.html();

                $.ajax({
                    url: route('products.getProduct', [type, productId]),
                    method: "GET",

                    beforeSend: function() {
                        button.prop('disabled', true);
                        button.html(`
                            <i class="fa fa-spinner fa-spin mr-5"></i> Loading...
                        `);
                    },

                    success: function(res) {
                        if (res.status) {
                            $('#quickViewModal').html(res.modal);
                            $('#quickViewModal').modal('show');
                            initVariantJs();
                        }
                    },

                    error: function(error) {
                        console.log(error);
                    },

                    complete: function() {
                        button.prop('disabled', false);
                        button.html(originalHtml);
                    }
                });
            }



            // initialize variants
            function initVariantJs() {
                const variantData = JSON.parse($('#variants-data').val());
                let selectedValues = new Set();


                //Filter color/Size
                $('.list-filter').each(function() {
                    $(this).find('a').on('click', function(event) {
                        event.preventDefault();
                        $(this).parent().siblings().removeClass('active');
                        $(this).parent().addClass('active');
                        $(this).parents('.attr-detail').find('.current-size').text($(this).text());
                        $(this).parents('.attr-detail').find('.current-color').text($(this).attr(
                            'data-color'));
                    });
                });


                //Qty Up-Down
                $('.detail-qty').each(function() {
                    var qtyval = parseInt($(this).find(".qty-val").val(), 10);
                    var $qtyInput = $(this).find(".qty-val");

                    $(this).find('.qty-up').on('click', function(event) {
                        event.preventDefault();
                        qtyval = qtyval + 1;
                        $qtyInput.val(qtyval);
                    });

                    $(this).find(".qty-down").on("click", function(event) {
                        event.preventDefault(); /*  */
                        qtyval = Math.max(1, qtyval - 1);
                        $qtyInput.val(qtyval);
                    });
                });

                // console.log(variantData);

                // function selectedDefaultVariant() {
                //     if (variantData.length > 0) {
                //         // loop through variants
                //         variantData.forEach((val, index) => {
                //             const attributeValues = variantData[0];
                //             // get default value
                //             const is_default = val.default;
                //             const is_active = val.is_active;
                //             const manage_stock = val.manage_stock;
                //             const qty = val.qty;
                //             const in_stock = val.in_stock;

                //             if (manage_stock) {
                //                 if (qty < 1) continue;

                //                 attributeValues.attribute_values.forEach(valueId => {
                //                     const $badge = $(`.attribute-badge[data-value="${valueId}"]`);
                //                     $badge.addClass('active');
                //                     selectedValues.add(valueId);
                //                 });
                //             }



                //             // check if default value is true
                //             // if (is_default && is_active) {
                //             //     // loop throught it attr values
                //             //     // attributeValues.attribute_values.forEach(valueId => {
                //             //     //     const $badge = $(`.attribute-badge[data-value="${valueId}"]`);
                //             //     //     $badge.addClass('active');
                //             //     //     selectedValues.add(valueId);
                //             //     // });

                //             //     // updatePrice(selectedValues);
                //             // }



                //             updatePrice(selectedValues);
                //         })
                //     }
                // }


                function selectedDefaultVariant() {
                    if (!variantData.length) return;

                    let selectedVariant = null;

                    // First priority:
                    // Find default active variant
                    selectedVariant = variantData.find(variant => {
                        return variant.default && variant.is_active && ((variant.manage_stock && variant
                            .qty > 0 && variant.in_stock) || (variant.manage_stock == 0 && variant
                            .in_stock == 1));
                    });

                    // First priority:
                    // Find first variant with managed stock and qty > 0
                    if (!selectedVariant) {
                        selectedVariant = variantData.find(variant => {
                            return variant.manage_stock && variant.qty > 0 && variant.in_stock;
                        });
                    }

                    // Second priority:
                    // Find first variant with managed stock == 0 and in stock for unlimited stock
                    if (!selectedVariant) {
                        selectedVariant = variantData.find(variant => {
                            return variant.manage_stock == 0 && variant.in_stock == 1;
                        });
                    }

                    // Final fallback:
                    // Use first variant
                    if (!selectedVariant) {
                        selectedVariant = variantData[0];
                    }

                    // Clear previous selections
                    $('.attribute-badge').removeClass('active');
                    selectedValues.clear();

                    // Activate selected variant attributes
                    selectedVariant.attribute_values.forEach(valueId => {
                        const $badge = $(`.attribute-badge[data-value="${valueId}"]`);
                        $badge.addClass('active');
                        selectedValues.add(valueId);
                    });

                    // Update price once
                    updatePrice(selectedValues);
                }


                function updatePrice(selectedValues) {
                    const selectedValuesArray = Array.from(selectedValues);

                    const matchingVariant = variantData.find(variant => {
                        const variantValues = new Set(variant.attribute_values);
                        return selectedValuesArray.length === variantValues.size && selectedValuesArray
                            .every(
                                value => variantValues.has(value));
                    });

                    //   console.log(matchingVariant);

                    if (matchingVariant) {
                        // console.log(matchingVariant);
                        // print stock status
                        if (matchingVariant.qty >= 0 && matchingVariant.manage_stock == 1) {
                            const text =
                                `${matchingVariant.qty} item${matchingVariant.qty > 1 ? 's' : ''} In Stock`
                            $('.stock_status').text(text);
                        } else if (matchingVariant.in_stock === 1) {
                            $('.stock_status').text('Unlimited items in stock');
                        } else {
                            $('.stock_status').text('Out of stock');
                        }

                        $('.sku').text(matchingVariant.sku)
                        $('#selected_variant').val(matchingVariant.id);

                        // check if manage stock is true and qty is not less than one
                        if (matchingVariant.in_stock === 0 || matchingVariant.in_stock === null || (matchingVariant
                                .qty < 1 &&
                                matchingVariant.manage_stock === 1)) {
                            var html = `
                        <div class="product-price product_price primary-color float-left">
                            <span class="current-price text-brand">Out of Stock</span>
                        </div>
                        `;
                            $('.product_price').replaceWith(html);
                            return;
                        }

                        if (matchingVariant.special_price > 0) {
                            var html = `
                        <div class="product-price product_price primary-color float-left">
                            <span class="current-price text-brand">$${matchingVariant.special_price}</span>
                            <span>
                                <span class="old-price font-md ml-15">$${matchingVariant.price}</span>
                            </span>
                        </div>
                        `;
                        } else {
                            var html = `
                        <div class="product-price product_price primary-color float-left">
                            <span class="current-price text-brand">$${matchingVariant.price}</span>
                        </div>
                        `;
                        }

                        $('.product_price').replaceWith(html);
                    }

                }

                $('.attribute-badge').on('click', function() {
                    const $attributeGroup = $(this).closest('.attribute-group');

                    selectedValues = new Set(
                        $('.attribute-badge.active').map(function() {
                            return parseInt($(this).attr('data-value'));
                        }).get()
                    );

                    // console.log(selectedValues);

                    updatePrice(selectedValues);
                });


                selectedDefaultVariant();
                // console.log(selectedValues);
            }
        })
    </script>
@endpush
