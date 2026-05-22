@extends('frontend.dashboard.dashboard-app')

@section('dashboard_contents')
    <div class="wsus__shipping_address mb_40">

        <h4>
            Billing Address
            <a href="{{ route('address.index') }}" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </h4>

        <div class="login_form" id="loginform">
            <div class="panel-body">
                <h4>Edit Address</h4>

                <form action="{{ route('address.update', $address->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mt-20">

                        {{-- FIRST NAME --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $address->first_name) }}" placeholder="First Name *">
                                <x-input-error :messages="$errors->get('first_name')" />
                            </div>
                        </div>

                        {{-- LAST NAME --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="last_name" value="{{ old('last_name', $address->last_name) }}"
                                    placeholder="Last Name *">
                                <x-input-error :messages="$errors->get('last_name')" />
                            </div>
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email', $address->email) }}"
                                    placeholder="Email *">
                                <x-input-error :messages="$errors->get('email')" />
                            </div>
                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                                    placeholder="Phone *">
                                <x-input-error :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="address" rows="3" placeholder="Full Address *">{{ old('address', $address->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" />
                            </div>
                        </div>

                        {{-- STATE --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="state_id" id="state" class="form-control select-active">
                                    <option value="">Select State *</option>

                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" @selected(old('state_id', $address->state_id) == $state->id)>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('state_id')" />
                            </div>
                        </div>

                        {{-- CITY --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="city_id" id="city" class="form-control select-active">
                                    <option value="">Select City *</option>

                                    @if ($address->city)
                                        <option value="{{ $address->city_id }}" selected>
                                            {{ $address->city->name }}
                                        </option>
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('city_id')" />
                            </div>
                        </div>

                        {{-- ZIP --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" name="zip" value="{{ old('zip', $address->zip) }}"
                                    placeholder="Zip Code *">
                                <x-input-error :messages="$errors->get('zip')" />
                            </div>
                        </div>

                        {{-- COUNTRY (optional but good consistency) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <select name="country" class="form-control select-active">
                                    <option value="Nigeria" @selected($address->country == 'Nigeria')>
                                        Nigeria
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('country')" />
                            </div>
                        </div>

                        {{-- DEFAULT --}}
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                    value="1" @checked($address->is_default)>
                                <label class="form-check-label" for="is_default">
                                    Set as default address
                                </label>
                            </div>
                        </div>

                        {{-- SHIPPING WIDGET --}}
                        <div class="col-md-12">
                            <div id="shipping_widget" class="alert alert-info" style="display: none">
                                <strong>Estimated Delivery Cost:</strong>
                                <span id="shipping_cost">--</span>
                                <br>
                                <small id="shipping_rule"></small>
                                <br>
                                <small id="shipping_zone"></small>
                            </div>
                        </div>

                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-md" type="submit">
                            Update Address
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {

                let initialCityId = "{{ $address->city_id }}";

                // =========================
                // LOAD CITIES
                // =========================
                $('#state').on('change', function() {

                    let stateId = $(this).val();
                    let citySelect = $('#city');

                    citySelect.html('<option>Loading...</option>');
                    $('#shipping_widget').hide();

                    if (!stateId) {
                        citySelect.html('<option value="">Select City *</option>');
                        return;
                    }

                    $.ajax({
                        url: route('states.cities', stateId),
                        type: "GET",
                        success: function(res) {

                            citySelect.html('<option value="">Select City *</option>');

                            if (res.status) {
                                res.state_cities.cities.forEach(city => {
                                    citySelect.append(`
                                        <option value="${city.id}">
                                            ${city.name}
                                        </option>
                                    `);
                                });

                                // restore selected city in edit mode
                                if (initialCityId) {
                                    citySelect.val(initialCityId);
                                }
                            }
                        }
                    });
                });

                // trigger on load for edit
                if ($('#state').val()) {
                    $('#state').trigger('change');
                }

                // =========================
                // SHIPPING ESTIMATE
                // =========================
                $('#city').on('change', function() {

                    let cityId = $(this).val();

                    if (!cityId) {
                        $('#shipping_widget').hide();
                        return;
                    }

                    $.ajax({
                        url: route('address.delivery-cost', cityId),
                        method: "GET",
                        success: function(res) {

                            if (!res.status) {
                                $('#shipping_widget').hide();
                                return;
                            }

                            $('#shipping_widget').show();
                            $('#shipping_cost').text("₦" + res.cost.toLocaleString());
                            $('#shipping_zone').text("Zone: " + res.zone_name);
                            $('#shipping_rule').text("Shipping Rule: " + res.rule_name);
                        }
                    });

                });

            });
        </script>
    @endpush
@endsection
