  @props(['product', 'class' => 'col-md-6 col-lg-7 col-sm-12 col-xs-12', 'type' => 'detail'])

  <div class="{{ $class }}">
      <div class="detail-info pr-30 pl-30">
          <span class="stock-status out-stock"> Sale Off </span>
          <h2 class="title-detail {{ $type == 'modal' ? 'fs-3' : '' }}">{{ $product->name }}</h2>
          <div class="product-detail-rating">
              <div class="product-rate-cover text-end">
                  <div class="product-rate d-inline-block">
                      <div class="product-rating" style="width: 90%"></div>
                  </div>
                  <span class="font-small ml-5 text-muted"> (32 reviews)</span>
              </div>
          </div>
          <div class="clearfix product-price-cover">
              <div class="product-price product_price primary-color float-left {{ $type == 'modal' ? 'fs-6' : '' }}">
                  @php
                      $price = $product->effective_price_and_stock;
                  @endphp

                  @if ($price['old_price'] > 0)
                      {{-- <span>${{ $price['price'] }}</span>
                      <span class="old-price">${{ $price['old_price'] }}</span> --}}

                      <span class="current-price text-brand">${{ $price['price'] }}</span>
                      <span>
                          {{-- <span class="save-price font-md color3 ml-15">25% Off</span> --}}
                          <span class="old-price font-md ml-15">${{ $price['old_price'] }}</span>
                      </span>
                  @else
                      <span class="old-price font-md ml-15">${{ $price['old_price'] }}</span>
                  @endif
              </div>
          </div>

          @if ($type == 'detail')
              <div class="short-desc mb-30">
                  <p class="font-lg">{!! $product->short_description !!}</p>
              </div>
          @endif


          @foreach ($product->attributeWithValues as $attribute)
              <div class="attr-detail  attr-size mb-20">
                  <strong class="mr-10">{{ $attribute->name }}: </strong>

                  @if ($attribute->type === \App\Enums\ProductAttributeType::COLOR)
                      {{-- COLOR FILTER --}}
                      <ul class="attribute-group list-filter color_filter font-small"
                          data-attribute="{{ $attribute->id }}">
                          @foreach ($attribute->values as $value)
                              <li class="attribute-badge" data-value="{{ $value->id }}">
                                  <a href="#" style="background: {{ $value->color }};"
                                      title="{{ $value->label }}">
                                  </a>
                              </li>
                          @endforeach
                      </ul>
                  @else
                      {{-- TEXT FILTER (SIZE, etc) --}}
                      <ul class="attribute-group list-filter size-filter font-small"
                          data-attribute="{{ $attribute->id }}">
                          @foreach ($attribute->values as $value)
                              <li class="attribute-badge" data-value="{{ $value->id }}">
                                  <a href="#">{{ $value->label }}</a>
                              </li>
                          @endforeach
                      </ul>
                  @endif
              </div>
          @endforeach

          @php
              $variantsData = $product->variants->map(function ($variant) {
                  return [
                      'id' => $variant->id,
                      'price' => $variant->price,
                      'special_price' => $variant->special_price,
                      'sku' => $variant->sku,
                      'manage_stock' => $variant->manage_stock,
                      'qty' => $variant->qty,
                      'in_stock' => $variant->stock_status,
                      'default' => $variant->is_default,
                      'is_active' => $variant->is_active,
                      'attribute_values' => $variant->attributeValues->pluck('id'),
                  ];
              });
          @endphp

          <input type="hidden" id="variants-data" value='@json($variantsData)'>
          <input type="hidden" name="" id="selected_variant" value="">


          <div class="detail-extralink mb-50">
              <div class="detail-qty border radius">
                  <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                  <input type="text" name="quantity" class="qty-val" value="1" min="1">
                  <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
              </div>
              <div class="product-extra-link2">
                  <button type="submit" data-id="{{ $product->id }}" data-type="{{ $product->product_type }}"
                      class="button button-add-to-cart add_to_cart_btn "><i class="fi-rs-shopping-cart"></i>Add to
                      cart</button>
                  @if ($type == 'detail')
                      <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i
                              class="fi-rs-heart"></i></a>
                      <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i
                              class="fi-rs-shuffle"></i></a>
                  @endif
              </div>
          </div>
          <div class="font-xs">
              <ul class="float-start">
                  <li class="mb-5">SKU: <a href="javascript:;" class="sku">
                          @if ($product?->primaryVariant)
                              {{ $product->primaryVariant->sku }}
                          @else
                              {{ $product->sku }}
                          @endif

                      </a></li>
                  <li class="mb-5">Tags:
                      @php
                          $count = count($product->tags);
                          // dd($count);
                          $inc = 0;
                      @endphp
                      @foreach ($product->tags as $tag)
                          @php
                              $inc++;
                          @endphp
                          <a href="#" rel="tag">{{ $tag->name }}</a>{{ $inc !== $count ? ',' : '' }}
                      @endforeach
                  </li>
                  <li>Stock:<span class="in-stock text-brand ml-5 stock_status">
                          @if ($product->primaryVariant)
                              @if ($product->primaryVariant->manage_stock === 1 && $product->primaryVariant->qty > 0)
                                  {{ $product->primaryVariant->qty }}
                                  {{ \Str::plural('Item', $product->primaryVariant->qty) }} In
                                  Stock
                              @elseif ($product->primaryVariant->manage_stock === 1 && $product->primaryVariant->qty <= 0)
                                  Out of Stock
                              @else
                                  <!-- Handle non-managed stock or default status -->
                                  In Stock
                              @endif
                          @else
                              @if ($product->manage_stock === 'yes' && $product->qty > 0 && $product->stock_status === 1)
                                  {{ $product->qty }} {{ \Str::plural('Item', $product->qty) }} In
                                  Stock
                              @elseif (($product->manage_stock === 'yes' && $product->qty <= 0) || $product->stock_status === 0)
                                  Out of Stock
                              @else
                                  <!-- Handle non-managed stock or default status -->
                                  Unlimited Stock
                              @endif
                          @endif

                      </span>
                  </li>
              </ul>
          </div>
      </div>
      <!-- Detail Info -->
  </div>
