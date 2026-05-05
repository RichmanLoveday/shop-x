   @props(['product', 'class' => 'col-md-6 col-lg-5 col-sm-12 col-xs-12 mb-md-0 mb-sm-5'])
   <div class="{{ $class }}">
       <div class="detail-gallery">
           <span class="zoom-icon"><i class="fi-rs-search"></i></span>
           <!-- MAIN SLIDES -->
           <div class="product-image-slider">
               @if ($product->images)
                   @foreach ($product->images as $image)
                       <figure class="border-radius-10">
                           <img src="{{ $image->path }}" alt="{{ $product->name }}" />
                       </figure>
                   @endforeach
               @else
                   <figure class="border-radius-10">
                       <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" />
                   </figure>
               @endif

           </div>
           <!-- THUMBNAILS -->
           <div class="slider-nav-thumbnails">
               @if ($product->images->count() > 0)
                   @foreach ($product->images as $image)
                       <div><img src="{{ $image->path }}" alt="product image" /></div>
                   @endforeach
               @else
                   <div><img src="{{ $product->thumbnail }}" alt="product image" /></div>
               @endif

           </div>
       </div>
   </div>
