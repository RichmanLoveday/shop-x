@extends('admin.payment-settings.index')

@section('payment_settings_contents')
    <div class="card-body">
        <h2 class="mb-4">Flutterwave Settings</h2>

        <form action="{{ route('admin.payment-settings.flutterwave.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- STATUS --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Status</label>
                    <select name="flutterwave_status" class="form-select">
                        <option @selected($flutterwaveSettings->flutterwave_status == 'active') value="active">Active</option>
                        <option @selected($flutterwaveSettings->flutterwave_status == 'inactive') value="inactive">Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('flutterwave_status')" class="mt-2" />
                </div>

                {{-- MODE --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Mode</label>
                    <select name="flutterwave_mode" class="form-select">
                        <option @selected($flutterwaveSettings->flutterwave_mode == 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected($flutterwaveSettings->flutterwave_mode == 'live') value="live">Live</option>
                    </select>
                    <x-input-error :messages="$errors->get('flutterwave_mode')" class="mt-2" />
                </div>

                {{-- COUNTRY --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Country</label>
                    <select name="flutterwave_country" id="flutterwave_country" class="form-select select2">
                        @foreach ($countries['flutterwave'] as $code => $country)
                            <option @selected($flutterwaveSettings->flutterwave_country == $code) value="{{ $code }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('flutterwave_country')" class="mt-2" />
                </div>

                {{-- CURRENCY --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Currency</label>
                    <input readonly type="text" id="flutterwave_currency_icon" class="form-control" value="{{ $flutterwaveSettings->flutterwave_currency_icon }}"
                        name="flutterwave_currency_icon">
                    <x-input-error :messages="$errors->get('flutterwave_currency_icon')" class="mt-2" />
                </div>

                {{-- RATE --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Currency Rate</label>
                    <input type="number" step="0.0001" name="flutterwave_currency_rate" class="form-control" value="{{ $flutterwaveSettings->flutterwave_currency_rate }}">
                    <x-input-error :messages="$errors->get('flutterwave_currency_rate')" class="mt-2" />
                </div>

                {{-- PUBLIC KEY --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Public Key</label>
                    <input type="text" name="flutterwave_public_key" class="form-control" value="{{ $flutterwaveSettings->flutterwave_public_key }}">
                    <x-input-error :messages="$errors->get('flutterwave_public_key')" class="mt-2" />
                </div>

                {{-- SECRET KEY --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Secret Key</label>
                    <input type="password" name="flutterwave_secret_key" class="form-control" value="{{ $flutterwaveSettings->flutterwave_secret_key }}">
                    <x-input-error :messages="$errors->get('flutterwave_secret_key')" class="mt-2" />
                </div>

                {{-- ENCRYPTION KEY --}}
                <div class="col-md-6">
                    <label class="form-label">Flutterwave Encryption Key</label>
                    <input type="password" name="flutterwave_encryption_key" class="form-control" value="{{ $flutterwaveSettings->flutterwave_encryption_key }}">
                    <x-input-error :messages="$errors->get('flutterwave_encryption_key')" class="mt-2" />
                </div>

                {{-- WEBHOOK --}}
                <div class="col-md-12">
                    <label class="form-label">Flutterwave Webhook URL</label>
                    <input type="text" name="flutterwave_webhook_url" class="form-control" value="{{ $flutterwaveSettings->flutterwave_webhook_url }}">
                    <small class="form-hint">Optional but recommended</small>
                </div>

            </div>

           <div class="btn-list justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    Save Flutterwave Settings
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#flutterwave_country').change(function() {
                    var selectedCurrency = $(this).val();
                    $.ajax({
                        url: route('admin.settings.currency-symbol'),
                        method: 'GET',
                        data: {
                            currency_code: selectedCurrency
                        },
                        success: function(response) {
                            $('#flutterwave_currency_icon').val(response.currency_symbol);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
