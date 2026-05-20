@extends('frontend.dashboard.dashboard-app')
@section('dashboard_contents')
    <div class="wsus__shipping_address mb_40">
        <h4>Billing Address
            <a href="{{ route('address.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                Back</a>
        </h4>

        {{-- <div class="row">
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="wsus__shipping_address_item">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                                value="option1">
                            <label class="form-check-label" for="inlineRadio1">98 Winn
                                St, Woburn, MA
                                01801,USA</label>
                        </div>
                        <div class="wsus__shipping_mail_address">
                            <a href="mailto:example@gmail.com">example@gmail.com</a>
                            <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                        </div>
                        <ul class="btn_list">
                            <li>
                                <a href="dashboard_address_edit.html">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="wsus__shipping_address_item">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                                value="option2">
                            <label class="form-check-label" for="inlineRadio2">98 Winn
                                St, Woburn, MA 01801,
                                USA</label>
                        </div>
                        <div class="wsus__shipping_mail_address">
                            <a href="mailto:example@gmail.com">example@gmail.com</a>
                            <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                        </div>
                        <ul class="btn_list">
                            <li>
                                <a href="dashboard_address_edit.html">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="wsus__shipping_address_item">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3"
                                value="option3">
                            <label class="form-check-label" for="inlineRadio3">98 Winn
                                St, Woburn, MA 01801,
                                USA</label>
                        </div>
                        <div class="wsus__shipping_mail_address">
                            <a href="mailto:example@gmail.com">example@gmail.com</a>
                            <a href="callto:+(402)76328246">+(402) 763 282 46</a>
                        </div>
                        <ul class="btn_list">
                            <li>
                                <a href="#">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}

        <div class="login_form" id="loginform">
            <div class="panel-body">
                <h4>Add New Address</h4>

                <form action="{{ route('address.store') }}" method="POST">
                    @csrf

                    <div class="row mt-20">

                        {{-- First Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name" value="{{ old('first_name') }}"
                                    placeholder="First Name *">

                                <x-input-error :messages="$errors->get('first_name')" />
                            </div>
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="last_name" value="{{ old('last_name') }}"
                                    placeholder="Last Name *">

                                <x-input-error :messages="$errors->get('last_name')" />
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email *">

                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone *">

                                <x-input-error :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="address" rows="3" placeholder="Full Address *">{{ old('address') }}</textarea>

                                <x-input-error :messages="$errors->get('address')" />
                            </div>
                        </div>

                        {{-- State --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="state" class="form-control select-active">
                                    <option value="">Select State *</option>

                                    @foreach (config('nigeria.states') as $state)
                                        <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('state')" />
                            </div>
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="city" value="{{ old('city') }}" placeholder="City *">

                                <x-input-error :messages="$errors->get('city')" />
                            </div>
                        </div>

                        {{-- Zip Code --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" name="zip" value="{{ old('zip') }}" placeholder="Zip Code *">

                                <x-input-error :messages="$errors->get('zip')" />
                            </div>
                        </div>

                        {{-- Country --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="country" class="form-control select-active">
                                    <option value="Nigeria" selected>
                                        Nigeria
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('country')" />
                            </div>
                        </div>

                        {{-- Default Address --}}
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                    value="1" {{ old('is_default') ? 'checked' : '' }}>

                                <label class="form-check-label" for="is_default">
                                    Set as default address
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-md" type="submit">
                            Save Address
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection
