@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">
        <div class="row row-deck row-cards space-y-4">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Create Shipping Rule</h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.shipping-rules.index') }}" class="btn btn-primary btn-3">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.shipping-rules.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                {{-- Rule Name --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            Rule Name
                                        </label>

                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="e.g Free shipping over $100" required>

                                        <x-input-error :messages="$errors->get('name')" />
                                    </div>
                                </div>

                                {{-- Rule Type --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            Shipping Type
                                        </label>

                                        <select name="type" id="shippingType" class="form-control" required>
                                            <option value="">--- Select Type ---</option>

                                            @foreach (\App\Enums\ShippingRulesType::cases() as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ old('type') == $type->value ? 'selected' : '' }}>
                                                    {{ $type->label() }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <x-input-error :messages="$errors->get('type')" />
                                    </div>
                                </div>

                                {{-- Minimum Order --}}
                                <div class="col-md-12 d-none" id="minimumOrderWrapper">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            Minimum Amount
                                        </label>

                                        <input type="number" step="0.01" min="0" name="minimum_amount"
                                            class="form-control minimum_amount" value="{{ old('minimum_amount') }}"
                                            placeholder="0.00" required>

                                        <x-input-error :messages="$errors->get('minimum_amount')" />
                                    </div>
                                </div>

                                {{-- Shipping Charge --}}
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label required">
                                            Shipping Charge
                                        </label>

                                        <input type="number" step="0.01" min="0" name="charge"
                                            class="form-control" value="{{ old('charge') }}" placeholder="0.00" required>

                                        <x-input-error :messages="$errors->get('charge')" />
                                    </div>
                                </div>

                                {{-- Active --}}
                                <div class="col-md-12">
                                    <div class="mb-3 mt-4">
                                        <label class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                                {{ old('is_active') ? 'checked' : '' }}>

                                            <span class="form-check-label">
                                                Active
                                            </span>
                                        </label>

                                        <x-input-error :messages="$errors->get('is_active')" />
                                    </div>
                                </div>

                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary" type="submit">
                                    Create Shipping Rule
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

                function toggleMinimumOrder() {
                    let type = $('#shippingType').val();

                    if (type === 'minimum_order_amount') {
                        $('#minimumOrderWrapper').removeClass('d-none');
                    } else {
                        $('#minimumOrderWrapper').addClass('d-none');
                        $('.minimum_amount').val('0');
                    }
                }

                // run on page load (important for old() value)
                toggleMinimumOrder();

                // run on change
                $('#shippingType').on('change', function() {
                    toggleMinimumOrder();
                });

            });
        </script>
    @endpush
@endsection
