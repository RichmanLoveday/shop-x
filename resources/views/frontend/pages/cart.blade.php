@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => '/cart', 'label' => 'Cart']]" />

    <div class="container mb-60 mt-55">
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex flex-wrap justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand">3</span> products in your cart</h6>
                    <h6 class="text-body"><a href="javascript:void(0)" id="delete-selected" class="text-muted"><i
                                class="fi-rs-trash mr-5"></i>Clear
                            Cart</a></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
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
                    <a class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                </div>
                <div class="row mt-50">
                    <div class="col-lg-7">
                        <div class="calculate-shiping p-40 border-radius-15 border">
                            <h4 class="mb-10">Calculate Shipping</h4>
                            <p class="mb-30"><span class="font-lg text-muted">Flat rate:</span><strong
                                    class="text-brand">5%</strong></p>
                            <form class="field_form shipping_calculator">
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <div class="custom_select">
                                            <select class="form-control select-active w-100">
                                                <option value="">United Kingdom</option>
                                                <option value="AX">Aland Islands</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="PW">Belau</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia</option>
                                                <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="VG">British Virgin Islands</option>
                                                <option value="BN">Brunei</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo (Brazzaville)</option>
                                                <option value="CD">Congo (Kinshasa)</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">CuraÇao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and McDonald Islands</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="CI">Ivory Coast</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Laos</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao S.A.R., China</option>
                                                <option value="MK">Macedonia</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia</option>
                                                <option value="MD">Moldova</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="AN">Netherlands Antilles</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="KP">North Korea</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PS">Palestinian Territory</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="QA">Qatar</option>
                                                <option value="IE">Republic of Ireland</option>
                                                <option value="RE">Reunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russia</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="ST">São Tomé and Príncipe</option>
                                                <option value="BL">Saint Barthélemy</option>
                                                <option value="SH">Saint Helena</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="SX">Saint Martin (Dutch part)</option>
                                                <option value="MF">Saint Martin (French part)</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="SM">San Marino</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia/Sandwich Islands</option>
                                                <option value="KR">South Korea</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syria</option>
                                                <option value="TW">Taiwan</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom (UK)</option>
                                                <option value="US">USA (US)</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VA">Vatican</option>
                                                <option value="VE">Venezuela</option>
                                                <option value="VN">Vietnam</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="WS">Western Samoa</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row row">
                                    <div class="form-group col-lg-6">
                                        <input required="required" placeholder="State / Country" name="name"
                                            type="text">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <input required="required" placeholder="PostCode / ZIP" name="name"
                                            type="text">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="p-40">
                    <h4 class="mb-10">Apply Coupon</h4>
                    <p class="mb-30"><span class="font-lg text-muted">Using A Promo Code?</p>
                    <form action="#" class="coupon-form">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <input class="font-medium mr-15 coupon coupon-input" {{ $appliedCoupon ? 'disabled' : '' }}
                                value="{{ $appliedCoupon['code'] ?? '' }}" name="coupon"
                                placeholder="Enter Your Coupon">
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
                    <a href="#" class="btn w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
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
            $(document).on('click', '.delete-item', function(event) {
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
