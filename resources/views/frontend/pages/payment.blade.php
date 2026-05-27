@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => '/payment', 'label' => 'Payment']]" />
    <div class="container mb-60 mt-65">
        <div class="wsus__payment_area">
            <div class="row">
                <div class="col-lg-6 col-xl-8 wow fadeInUp">
                    <h4>Select Payment </h4>
                    <div class="row mt-10">
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_1.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_2.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_3.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_4.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_5.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_6.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_7.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_12.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_8.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_9.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_10.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-6 col-xl-3 wow fadeInUp">
                            <a href="#" class="wsus__payment_method" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <img src="assets/imgs/payment_11.png" alt="payment" class="img-fluid w-100">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 wow fadeInUp">
                    <div class="wsus__billing_summary mt-45">
                        <h4>Billing Summery</h4>
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
                        </ul>
                        <div class="wsus__total_price">
                            <h3>Total <span>$ 360.00</span></h3>
                            <p>Shipping Charge <span>00.00</span></p>
                            <p>Discount <span>00.00</span></p>
                            <p>Tax <span>00.00</span></p>
                        </div>
                        <h5>Sub Total <span>$ 360.00</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal_payment_popup">
                        <p>From sleek racing flats to burly hiking boots, there are plenty of options to keep your
                            feet
                            comfortable during any activity. Read on to learn how to determine the right athletic
                            shoes
                            to
                            wear for whatever athletic pursuit you're embarking on.</p>

                        <ul class="modal_iteam">
                            <li>One popular belief, Lorem Ipsum is not simply random.</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                            <li>To popular belief, Lorem Ipsum is not simply random.</li>
                        </ul>
                        <form class="modal_form">
                            <div class="single_form">
                                <label>Enter Something</label>
                                <input type="text" placeholder="Enter Something">
                            </div>
                            <div class="single_form">
                                <label>Enter Something</label>
                                <textarea rows="3" placeholder="Enter Something"></textarea>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="modal_closs_btn btn hover-up"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn hover-up">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
