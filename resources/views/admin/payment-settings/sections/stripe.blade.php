@extends('admin.payment-settings.index')

@section('payment_settings_contents')
    <div class="card-body">
        <h2 class="mb-4">Stripe Settings</h2>

        <form action="{{ route('admin.payment-settings.stripe.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- STATUS --}}
                <div class="col-md-6">
                    <label class="form-label">Stripe Status</label>
                    <select name="stripe_status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('stripe_status')" class="mt-2" />
                </div>

                {{-- MODE --}}
                <div class="col-md-6">
                    <label class="form-label">Stripe Mode</label>
                    <select name="stripe_mode" class="form-select">
                        <option value="sandbox">Sandbox</option>
                        <option value="live">Live</option>
                    </select>
                    <x-input-error :messages="$errors->get('stripe_mode')" class="mt-2" />
                </div>

                {{-- COUNTRY --}}
                <div class="col-md-6">
                    <label class="form-label">Stripe Country</label>
                    <select name="stripe_country" id="stripe_country" class="form-select select2">
                        @foreach ($countries['stripe'] as $code => $country)
                            <option value="{{ $code }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('stripe_country')" class="mt-2" />
                </div>

                {{-- CURRENCY --}}
                <div class="col-md-6">
                    <label class="form-label">Stripe Currency</label>
                    <input disabled type="text" id="stripe_currency_icon" class="form-control"
                        value="" name="stripe_currency_icon">
                    <x-input-error :messages="$errors->get('stripe_currency_icon')" class="mt-2" />
                </div>

                {{-- CURRENCY RATE --}}
                <div class="col-md-6">
                    <label class="form-label">Stripe Currency Rate</label>
                    <div class="input-group">
                        <span class="input-group-text">1 USD =</span>
                        <input type="number" step="0.0001" name="stripe_currency_rate" class="form-control"
                            placeholder="0.00">
                    </div>
                    <small class="form-hint">
                        Conversion rate used for Stripe transactions.
                    </small>
                    <x-input-error :messages="$errors->get('stripe_currency_rate')" class="mt-2" />
                </div>

                {{-- PUBLISHABLE KEY --}}
                <div class="col-md-12">
                    <label class="form-label">Stripe Publishable Key</label>
                    <input type="text" name="stripe_publishable_key" class="form-control"
                        placeholder="pk_test_xxxxxxxxxxxxxxxxx">
                    <x-input-error :messages="$errors->get('stripe_publishable_key')" class="mt-2" />
                </div>

                {{-- SECRET KEY --}}
                <div class="col-md-12">
                    <label class="form-label">Stripe Secret Key</label>
                    <input type="password" name="stripe_secret_key" class="form-control"
                        placeholder="sk_test_xxxxxxxxxxxxxxxxx">
                    <x-input-error :messages="$errors->get('stripe_secret_key')" class="mt-2" />
                </div>

                {{-- WEBHOOK SECRET --}}
                <div class="col-md-12">
                    <label class="form-label">Stripe Webhook Secret</label>
                    <input type="password" name="stripe_webhook_secret" class="form-control"
                        placeholder="whsec_xxxxxxxxxxxxxxxxx">
                    <small class="form-hint">
                        Optional but strongly recommended for secure payment verification.
                    </small>
                    <x-input-error :messages="$errors->get('stripe_webhook_secret')" class="mt-2" />
                </div>
            </div>

            <div class="btn-list justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    Save Stripe Settings
                </button>
            </div>
        </form>


        @push('scripts')
            <script>
                $(document).ready(function() {
                    $('#stripe_country').change(function() {
                        var selectedCurrency = $(this).val();
                        $.ajax({
                            url: route('admin.settings.currency-symbol'),
                            method: 'GET',
                            data: {
                                currency_code: selectedCurrency
                            },
                            success: function(response) {
                                $('#stripe_currency_icon').val(response.currency_symbol);
                            }
                        });
                    });
                });
            </script>
        @endpush
    </div>
@endsection
