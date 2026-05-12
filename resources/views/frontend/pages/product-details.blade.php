@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('vendor.kyc.index'), 'label' => 'Kyc Verification']]" />
    <div class="container mb-30 overflow-hidden">
        <div class="row">
            <div class="col-xl-12">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-70">
                        <x-frontend.product-gallery :product='$product' />
                        <x-frontend.product-details-info :product='$product' />
                    </div>
                    <div class="product-info">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                        href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                        href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                        (3)</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            <tr class="stand-up">
                                                <th>Stand Up</th>
                                                <td>
                                                    <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-wo-wheels">
                                                <th>Folded (w/o wheels)</th>
                                                <td>
                                                    <p>32.5″L x 18.5″W x 16.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-w-wheels">
                                                <th>Folded (w/ wheels)</th>
                                                <td>
                                                    <p>32.5″L x 24″W x 18.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="door-pass-through">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Additional-info">
                                <table class="font-md">
                                    <tbody>
                                        <tr class="stand-up">
                                            <th>Stand Up</th>
                                            <td>
                                                <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                            </td>
                                        </tr>
                                        <tr class="folded-wo-wheels">
                                            <th>Folded (w/o wheels)</th>
                                            <td>
                                                <p>32.5″L x 18.5″W x 16.5″H</p>
                                            </td>
                                        </tr>
                                        <tr class="folded-w-wheels">
                                            <th>Folded (w/ wheels)</th>
                                            <td>
                                                <p>32.5″L x 24″W x 18.5″H</p>
                                            </td>
                                        </tr>
                                        <tr class="door-pass-through">
                                            <th>Door Pass Through</th>
                                            <td>
                                                <p>24</p>
                                            </td>
                                        </tr>
                                        <tr class="frame">
                                            <th>Frame</th>
                                            <td>
                                                <p>Aluminum</p>
                                            </td>
                                        </tr>
                                        <tr class="weight-wo-wheels">
                                            <th>Weight (w/o wheels)</th>
                                            <td>
                                                <p>20 LBS</p>
                                            </td>
                                        </tr>
                                        <tr class="weight-capacity">
                                            <th>Weight Capacity</th>
                                            <td>
                                                <p>60 LBS</p>
                                            </td>
                                        </tr>
                                        <tr class="width">
                                            <th>Width</th>
                                            <td>
                                                <p>24″</p>
                                            </td>
                                            <th>Door Pass Through</th>
                                            <td>
                                                <p>24</p>
                                            </td>
                                        </tr>
                                        <tr class="frame">
                                            <th>Frame</th>
                                            <td>
                                                <p>Aluminum</p>
                                            </td>
                                        </tr>
                                        <tr class="weight-wo-wheels">
                                            <th>Weight (w/o wheels)</th>
                                            <td>
                                                <p>20 LBS</p>
                                            </td>
                                        </tr>
                                        <tr class="weight-capacity">
                                            <th>Weight Capacity</th>
                                            <td>
                                                <p>60 LBS</p>
                                            </td>
                                        </tr>
                                        <tr class="width">
                                            <th>Width</th>
                                            <td>
                                                <p>24″</p>
                                            </td>
                                        </tr>
                                        <tr class="handle-height-ground-to-handle">
                                            <th>Handle height (ground to handle)</th>
                                            <td>
                                                <p>37-45″</p>
                                            </td>
                                        </tr>
                                        <tr class="wheels">
                                            <th>Wheels</th>
                                            <td>
                                                <p>12″ air / wide track slick tread</p>
                                            </td>
                                        </tr>
                                        <tr class="seat-back-height">
                                            <th>Seat back height</th>
                                            <td>
                                                <p>21.5″</p>
                                            </td>
                                        </tr>
                                        <tr class="head-room-inside-canopy">
                                            <th>Head room (inside canopy)</th>
                                            <td>
                                                <p>25″</p>
                                            </td>
                                        </tr>
                                        <tr class="pa_color">
                                            <th>Color</th>
                                            <td>
                                                <p>Black, Blue, Red, White</p>
                                            </td>
                                        </tr>
                                        <tr class="pa_size">
                                            <th>Size</th>
                                            <td>
                                                <p>M, S</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="Vendor-info">
                                <div class="vendor-logo d-flex mb-30 align-items-center">
                                    <img src="{{ $product->store->logo }}" alt="" />
                                    <div class="vendor-name ml-15">
                                        <h6>
                                            <a href="vendor-details-2.html">{{ $product->store->name }}</a>
                                        </h6>
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                        </div>
                                    </div>
                                </div>
                                <ul class="contact-infor mb-50">
                                    @if ($product->store->address)
                                        <li><img src="{{ asset('assets/frontend/imgs/theme/icons/icon-location.svg') }}"
                                                alt="" /><strong>Address: </strong>
                                            <span>{{ $product->store->address }}</span>
                                        </li>
                                    @endif
                                    @if ($product->store->phone)
                                        <li><img src="{{ asset('assets/frontend/imgs/theme/icons/icon-contact.svg') }}"
                                                alt="" /><strong>Contact
                                                Seller: </strong><span>{{ $product->store->phone }}</span></li>
                                    @endif
                                    @if ($product->store->email)
                                        <li><img src="{{ asset('assets/frontend/imgs/theme/icons/icon-contact.svg') }}"
                                                alt="" /><strong>Contact
                                                Email: </strong><span>{{ $product->store->email }}</span></li>
                                    @endif
                                </ul>
                                <div class="d-flex mb-55">
                                    <div class="mr-30">
                                        <p class="text-brand font-xs">Rating</p>
                                        <h4 class="mb-0">92%</h4>
                                    </div>
                                    <div class="mr-30">
                                        <p class="text-brand font-xs">Ship on time</p>
                                        <h4 class="mb-0">100%</h4>
                                    </div>
                                    <div>
                                        <p class="text-brand font-xs">Chat response</p>
                                        <h4 class="mb-0">89%</h4>
                                    </div>
                                </div>
                                <p>{!! $product->store->short_desc !!}</p>
                            </div>
                            <div class="tab-pane fade" id="Reviews">
                                <!--Comments-->
                                <div class="comments-area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4 class="mb-30">Customer questions & answers</h4>
                                            <div class="comment-list">
                                                <div class="single-comment justify-content-between d-flex mb-30">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb text-center">
                                                            <img src="assets/imgs/blog/author-2.png" alt="" />
                                                            <a href="#" class="font-heading text-brand">Sienna</a>
                                                        </div>
                                                        <div class="desc">
                                                            <div class="d-flex justify-content-between mb-10">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="font-xs text-muted">December 4,
                                                                        2024 at 3:12 pm </span>
                                                                </div>
                                                                <div class="product-rate d-inline-block">
                                                                    <div class="product-rating" style="width: 100%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                consectetur adipisicing elit. Delectus, suscipit
                                                                exercitationem accusantium obcaecati quos
                                                                voluptate nesciunt facilis itaque modi commodi
                                                                dignissimos sequi repudiandae minus ab deleniti
                                                                totam officia id incidunt? <a href="#"
                                                                    class="reply">Reply</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-comment justify-content-between d-flex mb-30 ml-30">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb text-center">
                                                            <img src="assets/imgs/blog/author-3.png" alt="" />
                                                            <a href="#" class="font-heading text-brand">Brenna</a>
                                                        </div>
                                                        <div class="desc">
                                                            <div class="d-flex justify-content-between mb-10">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="font-xs text-muted">December 4,
                                                                        2024 at 3:12 pm </span>
                                                                </div>
                                                                <div class="product-rate d-inline-block">
                                                                    <div class="product-rating" style="width: 80%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                consectetur adipisicing elit. Delectus, suscipit
                                                                exercitationem accusantium obcaecati quos
                                                                voluptate nesciunt facilis itaque modi commodi
                                                                dignissimos sequi repudiandae minus ab deleniti
                                                                totam officia id incidunt? <a href="#"
                                                                    class="reply">Reply</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-comment justify-content-between d-flex">
                                                    <div class="user justify-content-between d-flex">
                                                        <div class="thumb text-center">
                                                            <img src="assets/imgs/blog/author-4.png" alt="" />
                                                            <a href="#" class="font-heading text-brand">Gemma</a>
                                                        </div>
                                                        <div class="desc">
                                                            <div class="d-flex justify-content-between mb-10">
                                                                <div class="d-flex align-items-center">
                                                                    <span class="font-xs text-muted">December 4,
                                                                        2024 at 3:12 pm </span>
                                                                </div>
                                                                <div class="product-rate d-inline-block">
                                                                    <div class="product-rating" style="width: 80%">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="mb-10">Lorem ipsum dolor sit amet,
                                                                consectetur adipisicing elit. Delectus, suscipit
                                                                exercitationem accusantium obcaecati quos
                                                                voluptate nesciunt facilis itaque modi commodi
                                                                dignissimos sequi repudiandae minus ab deleniti
                                                                totam officia id incidunt? <a href="#"
                                                                    class="reply">Reply</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <h4 class="mb-30">Customer reviews</h4>
                                            <div class="d-flex mb-30">
                                                <div class="product-rate d-inline-block mr-15">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <h6>4.8 out of 5</h6>
                                            </div>
                                            <div class="progress">
                                                <span>5 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <span>4 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <span>3 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: 45%"
                                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <span>2 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: 65%"
                                                    aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%
                                                </div>
                                            </div>
                                            <div class="progress mb-30">
                                                <span>1 star</span>
                                                <div class="progress-bar" role="progressbar" style="width: 85%"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%
                                                </div>
                                            </div>
                                            <a href="#" class="font-xs text-muted">How are ratings
                                                calculated?</a>
                                        </div>
                                    </div>
                                </div>
                                <!--comment form-->
                                <div class="comment-form">
                                    <h4 class="mb-15">Add a review</h4>
                                    <div class="product-rate d-inline-block mb-30"></div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            <form class="form-contact comment_form" action="#" id="commentForm">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                                                placeholder="Write Comment"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input class="form-control" name="name" id="name"
                                                                type="text" placeholder="Name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <input class="form-control" name="email" id="email"
                                                                type="email" placeholder="Email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input class="form-control" name="website" id="website"
                                                                type="text" placeholder="Website" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="button button-contactForm">Submit
                                                        Review</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-70">
                    <div class="col-12">
                        <h2 class="section-title style-1 mb-30">Related products</h2>
                    </div>
                    <div class="col-12">
                        <div class="row related-products">
                            @foreach ($relatedProducts as $product)
                                <x-frontend.product-card :product="$product" class="col-6 col-lg-4 col-xl-3 col-xxl-2" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            const variantData = JSON.parse($('#variants-data').val());
            let selectedValues = new Set();

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

            //             console.log(manage_stock);

            //             if (manage_stock) {
            //                 if (qty < 1) {

            //                 }

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

            //             // attributeValues.attribute_values.forEach(valueId => {
            //             //     const $badge = $(`.attribute-badge[data-value="${valueId}"]`);
            //             //     $badge.addClass('active');
            //             //     selectedValues.add(valueId);
            //             // });

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
                    return variant.default && variant.is_active && ((variant.manage_stock && variant.qty >
                        0 && variant.in_stock) || (variant.manage_stock == 0 && variant.in_stock ==
                        1));
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
                    return selectedValuesArray.length === variantValues.size && selectedValuesArray.every(
                        value => variantValues.has(value));
                });

                // console.log(matchingVariant);


                if (matchingVariant) {
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
                } else {
                    notyf.error('Variant is inactive');
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

        });
    </script>
@endpush
