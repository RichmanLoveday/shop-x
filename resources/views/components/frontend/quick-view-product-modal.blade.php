  <div class="modal-dialog">
      <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body">
              <div class="row">
                  <x-frontend.product-gallery :product='$product' class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5" />
                  <x-frontend.product-details-info :product='$product' class="col-md-6 col-sm-12 col-xs-12"
                      type="modal" />
              </div>
          </div>
      </div>
  </div>


  <script>
      $('.product-image-slider').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: false,
          asNavFor: '.slider-nav-thumbnails',
      });

      $('.slider-nav-thumbnails').slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          asNavFor: '.product-image-slider',
          dots: false,
          focusOnSelect: true,

          prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
          nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>'
      });
  </script>
