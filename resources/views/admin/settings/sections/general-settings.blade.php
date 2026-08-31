@extends('admin.settings.index')
@section('settings_contents')
    <div class="card-body">
        <h2 class="mb-4">General Settings</h2>
        <form action="{{ route('admin.settings.general') }}" method="post">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="form-label">Site Name</div>
                    <input type="text" class="form-control" value="{{ $generalSettings->site_name }}" name="site_name">
                    <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                </div>
                <div class="col-md-6">
                    <div class="form-label">Contact Email</div>
                    <input type="email" class="form-control" value="{{ $generalSettings->site_email }}" name="site_email">
                    <x-input-error :messages="$errors->get('site_email')" class="mt-2" />
                </div>
                <div class="col-md-6">
                    <div class="form-label">Contact Phone</div>
                    <input type="text" class="form-control" value="{{ $generalSettings->site_phone }}" name="site_phone">
                    <x-input-error :messages="$errors->get('site_phone')" class="mt-2" />
                </div>

                <div class="col-md-6">
                    <div class="form-label">Default Currency</div>
                    <select name="site_currency" id="site_currency" class="form-control select2">
                        @foreach ($currencies as $currencyCode => $currencyName)
                            <option value="{{ $currencyCode }}"
                                {{ $generalSettings->site_currency === $currencyCode ? 'selected' : '' }}>
                                {{ $currencyName }} ({{ $currencyCode }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('site_currency')" class="mt-2" />
                </div>
                <div class="col-md-6">
                    <div class="form-label">Currency Icon</div>
                    <input disabled type="text" id="site_currency_icon" class="form-control" value="{{ $generalSettings->site_currency_icon }}"
                        name="site_currency_icon">
                    <x-input-error :messages="$errors->get('site_currency_icon')" class="mt-2" />
                </div>
            </div>

            <div class="btn-list justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-2"> Submit </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#site_currency').change(function() {
                    var selectedCurrency = $(this).val();
                    $.ajax({
                        url: route('admin.settings.currency-symbol'),
                        method: 'GET',
                        data: {
                            currency_code: selectedCurrency
                        },
                        success: function(response) {
                            $('#site_currency_icon').val(response.currency_symbol);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
