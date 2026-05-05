   @props(['class' => 'col-6 col-xxl-3 col-lg-4 col-md-6 col-sm-6'])

   <div {{ $attributes }} class="{{ $class }}">
       <div class="product-cart-wrap mb-30">
           <div class="product-img-action-wrap">
               <div class="product-img product-img-zoom">
                   <a href="{{ route('products.show', $product->slug) }}" class="d-block"
                       style="height: 250px; overflow: hidden;">
                       <img class="default-img w-100 h-100 object-fit-cover" src="{{ $product->thumbnail }}"
                           alt="" />
                       <img class="hover-img w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                           src="{{ optional($product->images->first())->path }}" alt="" />
                   </a>
               </div>
               <div class="product-action-1">
                   <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                           class="fi-rs-heart"></i></a>
                   <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                   <a aria-label="Quick view" class="action-btn quick_view" data-id="{{ $product->id }}"
                       data-type="{{ $product->product_type }}"><i class="fi-rs-eye"></i></a>
               </div>
               <div class="product-badges product-badges-position product-badges-mrg gap-1">
                   @if ($product->is_hot)
                       <span class="hot">Hot</span>
                   @endif

                   @if ($product->is_new)
                       <span class="hot">New</span>
                   @endif
               </div>
           </div>
           <div class="product-content-wrap">
               <div class="product-category">
                   {{-- <a href="shop-grid-right.html">Fashion</a> --}}
               </div>
               <h2><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h2>
               <div class="product-rate-cover">
                   <div class="product-rate d-inline-block">
                       <div class="product-rating" style="width: 90%"></div>
                   </div>
                   <span class="font-small ml-5 text-muted"> (4.0)</span>
               </div>
               <div>
                   <span class="font-small text-muted">By <a
                           href="vendor-details-1.html">{{ $product->store->name }}</a></span>
               </div>
               <div class="product-card-bottom">
                   <div class="product-price">
                       @if ($product->primaryVariant)
                           @if ($product->primaryVariant->special_price > 0)
                               <span>${{ $product->primaryVariant->special_price }}</span>
                               <span class="old-price">${{ $product->primaryVariant->price }}</span>
                           @else
                               <span>${{ $product->primaryVariant->special_price }}</span>
                           @endif
                       @else
                           @if ($product->special_price > 0)
                               <span>${{ $product->special_price }}</span>
                               <span class="old-price">${{ $product->price }}</span>
                           @else
                               <span class="old-price">${{ $product->price }}</span>
                           @endif
                       @endif
                   </div>
                   <div class="add-cart">
                       <a class="add add_to_cart" data-id="{{ $product->id }}"
                           data-type="{{ $product->product_type }}" data-variants="{{ $product->variants }}"
                           href="javascript:;"><i class="fi-rs-shopping-cart mr-5"></i>Add
                       </a>
                   </div>
               </div>
           </div>
       </div>
   </div>
