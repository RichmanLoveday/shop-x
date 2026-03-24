@extends('frontend.layout.app')
@section('contents')
    @include('frontend.home.sections.hero-section')
    @include('frontend.home.sections.categories-section')
    @include('frontend.home.sections.banner-section')
    @include('frontend.home.sections.product-tab-section')
    @include('frontend.home.sections.banner-section-two')
    @include('frontend.home.sections.flash-sale-section')
    @include('frontend.home.sections.new-arrival-section')

    <section class="wsus__ctg mt-40">
        <div class="container">
            <a href="#" class="wsus__ctg_area">
                <img src="assets/imgs/cta_bg.png" alt="cta" class="img-fluid w-100" />
            </a>
        </div>
    </section>
    <!--CTA section end-->
    @include('frontend.home.sections.special-products-section')
    @include('frontend.home.sections.for-all-products-section')
    <!--End 4 columns-->
@endsection
