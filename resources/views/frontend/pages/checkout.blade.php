@extends('frontend.layout.app')
@section('contents')
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

                <div class="row mb-30">
                    <div class="col-12">
                        <div class="toggle_info">
                            <span>
                                <i class="fi-rs-user mr-10"></i>
                                <span class="text-muted font-lg">Already have an account?</span>
                                <a href="login.html">Click here to login</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="wsus__shipping_address mb_40">
                    <h4>Billing Address
                        <a href="#loginform" data-bs-toggle="collapse" class="collapsed font-lg" aria-expanded="false">add
                            new address</a>
                    </h4>

                    <div class="panel-collapse collapse login_form" id="loginform">
                        <div class="panel-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Name ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" placeholder="Email ">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" placeholder="Phone ">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea placeholder="Address" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-md" name="login">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="option1">
                                    <label class="form-check-label" for="inlineRadio1">98 Winn St, Woburn, MA
                                        01801,USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">98 Winn St, Woburn, MA 01801,
                                        USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-4">
                            <div class="wsus__shipping_address_item">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio3" value="option3">
                                    <label class="form-check-label" for="inlineRadio3">98 Winn St, Woburn, MA 01801,
                                        USA</label>
                                </div>
                                <div class="wsus__shipping_mail_address">
                                    <a href="mailto:example@gmail.com">example@gmail.com</a>
                                    <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-30">
                    <form method="post">
                        <div class="ship_detail">
                            <div class="form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                            id="differentaddress">
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
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio1b" value="option1">
                                                <label class="form-check-label" for="inlineRadio1b">98 Winn St,
                                                    Woburn, MA
                                                    01801,USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio2b" value="option2">
                                                <label class="form-check-label" for="inlineRadio2b">98 Winn St,
                                                    Woburn, MA 01801,
                                                    USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-4">
                                        <div class="wsus__shipping_address_item">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio3b" value="option3">
                                                <label class="form-check-label" for="inlineRadio3b">98 Winn St,
                                                    Woburn, MA 01801,
                                                    USA</label>
                                            </div>
                                            <div class="wsus__shipping_mail_address">
                                                <a href="mailto:example@gmail.com">example@gmail.com</a>
                                                <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
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
                </div>

            </div>
            <div class="col-xl-4">
                <div class="wsus__billing_summary">
                    <h4>Billing Summery</h4>
                    <h5 class="vendor_name">Vendor Name</h5>
                    <ul class="wsus__billing_product">
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
                    <h5 class="vendor_name">Vendor Name</h5>
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
                        <li>
                            <a href="#" class="img">
                                <img src="assets/imgs/shop/product-1-1.jpg" alt="product" class="img-fluid w-100">
                            </a>
                            <div class="text">
                                <a href="#">Black Sneakers</a>
                                <h6>$120.00</h6>
                            </div>
                        </li>
                    </ul>
                    <div class="wsus__total_price">
                        <form method="post" class="apply-coupon mb-10">
                            <input type="text" placeholder="Enter Coupon Code...">
                            <button class="btn  btn-md" name="login">Apply Coupon</button>
                        </form>
                        <div class="show_coupon">
                            <p>Coupon code
                                <span>#154HGJ</span>
                                <a href="#"><i class="fi fi-rs-trash"></i></a>
                            </p>
                        </div>
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
@endsection
