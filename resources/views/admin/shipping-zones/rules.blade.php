@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">

                    {{-- HEADER --}}
                    <div class="card-header">
                        <h3 class="card-title">
                            Manage Shipping Charges - {{ $zone['zone_name'] }}
                        </h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-primary btn-3">
                                Back
                            </a>
                        </div>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.shipping-zones.rules.update', $zone['zone_id']) }}">
                            @csrf
                            @method('PUT')

                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">

                                    <thead>
                                        <tr>
                                            <th>Shipping Rule</th>
                                            <th>Base Charge</th>
                                            <th>Override Charge</th>
                                            <th>Final Charge</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($zone['shipping_rules'] as $rule)
                                            <tr>
                                                {{-- RULE NAME --}}
                                                <td>
                                                    <div class="fw-bold">
                                                        <a href="{{ route('admin.shipping-rules.edit', $rule['id']) }}"> {{ $rule['name'] }}</a>
                                                    </div>
                                                </td>

                                                {{-- BASE CHARGE --}}
                                                <td>
                                                    <span class="badge bg-blue-lt">
                                                        ₦{{ number_format($rule['base_charge'], 2) }}
                                                    </span>
                                                </td>

                                                {{-- HIDDEN RULE ID --}}
                                                <input type="hidden" name="shipping_rules[{{ $loop->index }}][id]"
                                                    value="{{ $rule['id'] }}">

                                                {{-- OVERRIDE INPUT --}}
                                                <td>
                                                    <input type="number" step="0.01" min="0" class="form-control"
                                                        name="shipping_rules[{{ $loop->index }}][override_charge]"
                                                        value="{{ old('shipping_rules.' . $loop->index . '.override_charge', $rule['override_charge']) }}"
                                                        placeholder="Leave empty to use ₦{{ number_format($rule['base_charge'], 2) }}">

                                                    @error('shipping_rules.' . $loop->index . '.override_charge')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </td>

                                                {{-- FINAL CHARGE --}}
                                                <td>
                                                    <span class="badge bg-success-lt">
                                                        ₦{{ number_format($rule['final_charge'], 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    No shipping rules found for this zone
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                            {{-- ACTION --}}
                            <div class="text-end mt-4">
                                <button class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
