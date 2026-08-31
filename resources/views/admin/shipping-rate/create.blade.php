@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">

                            Create Shipping Rate

                        </h3>

                        <div class="card-actions">

                            <a href="{{ route('admin.shipping-rates.index') }}" class="btn btn-primary btn-3">

                                <i class="ti ti-arrow-left me-1"></i>

                                Back

                            </a>

                        </div>

                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.shipping-rates.store') }}">

                            @csrf

                            <div class="row">

                                {{-- SHOP / VENDOR --}}

                                {{-- <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Vendor

                                    </label>

                                    <select name="store_id" class="form-control select2" required>

                                        <option value="">

                                            -- Select Vendor --

                                        </option>

                                        @foreach ($stores as $store)
                                            <option value="{{ $store->id }}"
                                                {{ old('store_id') == $store->id ? 'selected' : '' }}>

                                                {{ $store->name }}

                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="form-hint">

                                        Select the vendor this shipping rate applies to.

                                    </small>

                                    <x-input-error :messages="$errors->get('store_id')" />

                                </div> --}}

                                <div class="col-md-6 mb-3"> <label class="form-label required"> Vendor </label> <select
                                        name="store_id" class="form-control select2-store" required>
                                        <option value=""> -- Select Vendor -- </option>
                                        @if (old('store_id'))
                                            <option value="{{ old('store_id') }}" selected> {{ old('store_id') }} </option>
                                        @endif
                                    </select>

                                    <small class="form-hint">
                                        Search and select the vendor this shipping rate
                                        applies to.
                                    </small>
                                    <x-input-error :messages="$errors->get('store_id')" />

                                </div>


                                {{-- SHIPPING METHOD --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Shipping Method

                                    </label>

                                    <select name="shipping_method_id" class="form-control select2" required>

                                        <option value="">

                                            -- Select Shipping Method --

                                        </option>

                                        @foreach ($shippingMethods as $method)
                                            <option value="{{ $method->id }}"
                                                {{ old('shipping_method_id') == $method->id ? 'selected' : '' }}>

                                                {{ $method->name }}

                                                ({{ $method->min_days }}-{{ $method->max_days }} days)
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="form-hint">

                                        The delivery method customers can use for this rate.

                                    </small>

                                    <x-input-error :messages="$errors->get('shipping_method_id')" />

                                </div>


                                {{-- ORIGIN ZONE --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Origin Zone

                                    </label>

                                    <select name="origin_zone_id" id="origin_zone_id" class="form-control zone-select"
                                        data-placeholder="-- Search Origin Zone --"
                                        data-route="{{ route('admin.shipping-zones.name', ['name' => '__NAME__']) }}"
                                        required>

                                        <option value="">

                                            -- Search Origin Zone --

                                        </option>

                                    </select>

                                    <small class="form-hint">

                                        The zone where the shop is located.

                                    </small>

                                    <x-input-error :messages="$errors->get('origin_zone_id')" />

                                </div>


                                {{-- DESTINATION ZONE --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Destination Zone

                                    </label>

                                    <select name="destination_zone_id" id="destination_zone_id"
                                        class="form-control zone-select" data-placeholder="-- Search Destination Zone --"
                                        data-route="{{ route('admin.shipping-zones.name', ['name' => '__NAME__']) }}"
                                        required>

                                        <option value="">

                                            -- Search Destination Zone --

                                        </option>

                                    </select>

                                    <small class="form-hint">

                                        The zone where the customer will receive the order.

                                    </small>

                                    <x-input-error :messages="$errors->get('destination_zone_id')" />

                                </div>


                                {{-- MINIMUM ORDER --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Minimum Order Amount

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            ₦

                                        </span>

                                        <input type="number" name="min_order_amount" class="form-control"
                                            value="{{ old('min_order_amount', 0) }}" min="0" step="0.01"
                                            placeholder="0.00" required>

                                    </div>

                                    <small class="form-hint">

                                        The minimum cart value this rate applies to.

                                    </small>

                                    <x-input-error :messages="$errors->get('min_order_amount')" />

                                </div>


                                {{-- MAXIMUM ORDER --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Maximum Order Amount

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            ₦

                                        </span>

                                        <input type="number" name="max_order_amount" class="form-control"
                                            value="{{ old('max_order_amount') }}" min="0" step="0.01"
                                            placeholder="Leave empty for no limit">

                                    </div>

                                    <small class="form-hint">

                                        Leave empty if this rate has no maximum order value.

                                    </small>

                                    <x-input-error :messages="$errors->get('max_order_amount')" />

                                </div>


                                {{-- SHIPPING CHARGE --}}

                                <div class="col-md-6 mb-3">

                                    <label class="form-label required">

                                        Shipping Charge

                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">

                                            ₦

                                        </span>

                                        <input type="number" name="charge" class="form-control"
                                            value="{{ old('charge', 0) }}" min="0" step="0.01"
                                            placeholder="e.g. 5000" required>

                                    </div>

                                    <small class="form-hint">

                                        Enter 0 to provide free shipping for this order range.

                                    </small>

                                    <x-input-error :messages="$errors->get('charge')" />

                                </div>


                                {{-- ACTIVE --}}

                                <div class="col-md-12 mb-3">

                                    <div class="mb-3 mt-3">

                                        <label class="form-check form-switch">

                                            <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                                {{ old('is_active', true) ? 'checked' : '' }}>

                                            <span class="form-check-label">

                                                Active

                                            </span>

                                        </label>

                                        <small class="text-muted">

                                            Only active rates are considered when calculating

                                            delivery charges during checkout.

                                        </small>

                                        <x-input-error :messages="$errors->get('is_active')" />

                                    </div>

                                </div>

                            </div>


                            {{-- ROUTE PREVIEW --}}

                            <div class="alert alert-info mt-3">

                                <div class="d-flex">

                                    <div>

                                        <i class="ti ti-info-circle alert-icon"></i>

                                    </div>

                                    <div>

                                        <h4 class="alert-title">

                                            Shipping Rate Configuration

                                        </h4>

                                        <div class="text-secondary">

                                            This rate defines the delivery charge for a specific

                                            shop, shipping method, origin zone, destination zone

                                            and order-value range.

                                            <br>

                                            For example:

                                            <strong>

                                                ABC Store — Lagos Mainland → South South

                                            </strong>

                                            with a charge of

                                            <strong>

                                                ₦5,000

                                            </strong>

                                            for orders between

                                            <strong>

                                                ₦0 and ₦49,999

                                            </strong>.

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- SUBMIT --}}

                            <div class="text-end mt-4">

                                <a href="{{ route('admin.shipping-rates.index') }}" class="btn btn-link">

                                    Cancel

                                </a>

                                <button class="btn btn-primary" type="submit">

                                    <i class="ti ti-plus me-1"></i>

                                    Create Shipping Rate

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {

                $('.select2').select2({

                    width: '100%'

                });


                $('.select2-store').select2({
                    width: '100%',
                    placeholder: '-- Select Vendor --',
                    allowClear: true,
                    minimumInputLength: 2,
                    ajax: {
                        url: route('admin.stores.search'),
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                name: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.stores.map(function(store) {
                                    return {
                                        id: store.id,
                                        text: store.name
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });


                /**
                 * Shipping Zone Search
                 *
                 * Calls:
                 * GET /shipping-zone/{name}
                 *
                 * Example:
                 * GET /shipping-zone/lagos
                 */

                $('.zone-select').each(function() {

                    const select = $(this);

                    const route = select.data('route');

                    let searchTimeout = null;


                    select.select2({

                        width: '100%',

                        placeholder: select.data('placeholder'),

                        minimumInputLength: 2,

                        allowClear: true,

                        ajax: {

                            delay: 300,

                            transport: function(params, success, failure) {

                                clearTimeout(searchTimeout);


                                searchTimeout = setTimeout(function() {

                                    const search = params.data.q;


                                    if (!search || search.length < 2) {

                                        success({

                                            results: []

                                        });

                                        return;

                                    }


                                    const url = route.replace(

                                        '__NAME__',

                                        encodeURIComponent(search)

                                    );


                                    $.ajax({

                                        url: url,

                                        type: 'GET',

                                        dataType: 'json',

                                        success: function(response) {

                                            if (!response.status) {

                                                success({

                                                    results: []

                                                });

                                                return;

                                            }


                                            const zones = response
                                                .shipping_zones || [];


                                            success({

                                                results: zones.map(
                                                    function(
                                                        zone) {

                                                        return {

                                                            id: zone
                                                                .id,

                                                            text: zone
                                                                .name

                                                        };

                                                    })

                                            });

                                        },

                                        error: function(xhr) {

                                            console.error(

                                                'Unable to retrieve shipping zones.',

                                                xhr

                                            );


                                            failure(xhr);

                                        }

                                    });

                                }, 300);

                            },

                            processResults: function(data) {

                                return data;

                            }

                        }

                    });

                });

            });
        </script>
    @endpush
@endsection
