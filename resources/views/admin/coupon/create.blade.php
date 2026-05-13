@extends('admin.layout.app')

@section('contents')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Coupon</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary btn-3">
                                <i class="ti ti-arrow-left fs-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                {{-- Coupon Code --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Coupon Code</label>
                                        <input type="text" name="code" class="form-control"
                                            value="{{ old('code') }}" placeholder="e.g SUMMER20" required>
                                        <x-input-error :messages="$errors->get('code')" />
                                    </div>
                                </div>

                                {{-- Coupon Value --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Discount Value</label>
                                        <input type="number" step="0.01" name="value" class="form-control"
                                            value="{{ old('value') }}" required>
                                        <x-input-error :messages="$errors->get('value')" />
                                    </div>
                                </div>

                                {{-- Discount Type --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Discount Type</label>
                                        <select name="is_percent" class="form-select">
                                            <option value="0" {{ old('is_percent') == '0' ? 'selected' : '' }}>
                                                Fixed Amount
                                            </option>
                                            <option value="1" {{ old('is_percent') == '1' ? 'selected' : '' }}>
                                                Percentage (%)
                                            </option>
                                        </select>
                                        <x-input-error :messages="$errors->get('is_percent')" />
                                    </div>
                                </div>

                                {{-- Minimum Spend --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Minimum Spend</label>
                                        <input type="number" step="0.01" name="minimum_spend" class="form-control"
                                            value="{{ old('minimum_spend') }}" required>
                                        <x-input-error :messages="$errors->get('minimum_spend')" />
                                    </div>
                                </div>

                                {{-- Maximum Spend --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Maximum Spend</label>
                                        <input type="number" step="0.01" name="maximum_spend" class="form-control"
                                            value="{{ old('maximum_spend') }}" required>
                                        <x-input-error :messages="$errors->get('maximum_spend')" />
                                    </div>
                                </div>

                                {{-- Coupon Usage Limit --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Usage Limit Per Coupon</label>
                                        <input type="number" name="usage_limit_per_coupon" class="form-control"
                                            value="{{ old('usage_limit_per_coupon') }}" required>
                                        <x-input-error :messages="$errors->get('usage_limit_per_coupon')" />
                                    </div>
                                </div>

                                {{-- Customer Usage Limit --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Usage Limit Per Customer</label>
                                        <input type="number" name="usage_limit_per_customer" class="form-control"
                                            value="{{ old('usage_limit_per_customer') }}" required>
                                        <x-input-error :messages="$errors->get('usage_limit_per_customer')" />
                                    </div>
                                </div>

                                {{-- Start Date --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Start Date</label>
                                        <input type="date" name="start_date" class="form-control datepicker"
                                            value="{{ old('start_date') }}" required>
                                        <x-input-error :messages="$errors->get('start_date')" />
                                    </div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">End Date</label>
                                        <input type="date" name="end_date" class="form-control datepicker"
                                            value="{{ old('end_date') }}" required>
                                        <x-input-error :messages="$errors->get('end_date')" />
                                    </div>
                                </div>

                                {{-- Active Status --}}
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                {{ old('is_active') ? 'checked' : '' }}>
                                            <span class="form-check-label">Active</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-primary" type="submit">
                                        Create Coupon
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const $input = $('#brandLogo');
            const $preview = $('.preview-brand-logo');
            const $card = $('.brand-logo');

            $input.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $preview.attr('src', e.target.result);
                        $card.addClass('has-image');
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
