@extends('admin.payment-settings.index')

@section('payment_settings_contents')
    <div class="card-body">
        <h2 class="mb-4">Paystack Settings</h2>

        <form action="{{ route('admin.payment-settings.paystack.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- STATUS --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Status</label>
                    <select name="paystack_status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('paystack_status')" class="mt-2" />
                </div>

                {{-- MODE --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Mode</label>
                    <select name="paystack_mode" class="form-select">
                        <option value="sandbox">Sandbox</option>
                        <option value="live">Live</option>
                    </select>
                    <x-input-error :messages="$errors->get('paystack_mode')" class="mt-2" />
                </div>

                {{-- COUNTRY --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Country</label>
                    <select name="paystack_country" id="paystack_country" class="form-select select2">
                        @foreach ($countries['paystack'] as $code => $country)
                            <option value="{{ $code }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('paystack_country')" class="mt-2" />
                </div>

                {{-- CURRENCY --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Currency</label>
                    <input disabled type="text" id="paystack_currency_icon" class="form-control" value=""
                        name="paystack_currency_icon">
                    <x-input-error :messages="$errors->get('paystack_currency_icon')" class="mt-2" />
                </div>

                {{-- CURRENCY RATE --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Currency Rate</label>
                    <div class="input-group">
                        <span class="input-group-text">1 USD =</span>
                        <input type="number" step="0.0001" name="paystack_currency_rate" class="form-control"
                            placeholder="0.00">
                    </div>
                    <small class="form-hint">
                        Conversion rate used for Paystack transactions.
                    </small>
                    <x-input-error :messages="$errors->get('paystack_currency_rate')" class="mt-2" />
                </div>

                {{-- PUBLIC KEY --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Public Key</label>
                    <input type="text" name="paystack_public_key" class="form-control"
                        placeholder="pk_test_xxxxxxxxxxxxxxxxx">
                    <x-input-error :messages="$errors->get('paystack_public_key')" class="mt-2" />
                </div>

                {{-- SECRET KEY --}}
                <div class="col-md-6">
                    <label class="form-label">Paystack Secret Key</label>
                    <input type="password" name="paystack_secret_key" class="form-control"
                        placeholder="sk_test_xxxxxxxxxxxxxxxxx">
                    <x-input-error :messages="$errors->get('paystack_secret_key')" class="mt-2" />
                </div>

                {{-- WEBHOOK --}}
                <div class="col-md-12">
                    <label class="form-label">Paystack Webhook URL</label>
                    <input type="text" name="paystack_webhook_url" class="form-control"
                        placeholder="https://yourdomain.com/webhook/paystack">
                    <small class="form-hint">Optional but recommended</small>
                </div>

            </div>

            <div class="btn-list justify-content-end mt-4">
                <button type="submit" class="btn btn-primary">
                    Save Paystack Settings
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#paystack_country').change(function() {
                    var selectedCurrency = $(this).val();
                    $.ajax({
                        url: route('admin.settings.currency-symbol'),
                        method: 'GET',
                        data: {
                            currency_code: selectedCurrency
                        },
                        success: function(response) {
                            $('#paystack_currency_icon').val(response.currency_symbol);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
