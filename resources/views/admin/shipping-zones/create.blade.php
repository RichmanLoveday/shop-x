@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Create Shipping Zone</h3>

                        <div class="card-actions">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-3">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.shipping-zones.store') }}">
                            @csrf

                            <div class="row">

                                {{-- ZONE NAME --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Zone Name</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="e.g South South Zone" required>
                                </div>

                                {{-- STATE FILTER --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Filter State (optional)</label>

                                    <select id="state_id" class="form-control select2">
                                        <option value="">-- Select State --</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- CITY SELECT --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Add City</label>

                                    <select id="city_select" class="form-control select2">
                                        <option value="">Select city</option>
                                    </select>
                                </div>

                                {{-- SELECTED CITIES --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Selected Cities</label>

                                    <div id="selected_cities" class="d-flex flex-wrap gap-2 p-2 border rounded bg-light">
                                        <span class="text-muted">No cities selected yet</span>
                                    </div>

                                    {{-- SINGLE CLEAN INPUT CONTAINER --}}
                                    <div id="city_inputs"></div>
                                </div>

                                {{-- SHIPPING RULES --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label required">Shipping Rules</label>

                                    <select name="shipping_rule_ids[]" class="form-control select2" multiple>
                                        @foreach ($shippingRules as $rule)
                                            <option value="{{ $rule->id }}">
                                                {{ $rule->name }} (₦{{ number_format($rule->charge, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- ACTIVE --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                                            checked>
                                        <span class="form-check-label">Active</span>
                                    </label>
                                </div>

                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary">Create Zone</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {

                $('.select2').select2({
                    width: '100%'
                });

                const selectedCities = new Set();
                const cityMap = {};

                // =====================
                // LOAD CITIES
                // =====================
                $('#state_id').on('change', function() {

                    const stateId = $(this).val();

                    $('#city_select').html('<option>Loading...</option>');

                    if (!stateId) return;

                    $.get(route('admin.states.cities', [stateId]), function(res) {

                        $('#city_select').html('<option value="">Select city</option>');

                        res.state_cities.cities.forEach(city => {

                            cityMap[String(city.id)] = city.name;

                            if (!selectedCities.has(String(city.id))) {
                                $('#city_select').append(
                                    `<option value="${city.id}">${city.name}</option>`
                                );
                            }
                        });
                    });
                });

                // =====================
                // ADD CITY
                // =====================
                $('#city_select').on('change', function() {

                    let id = $(this).val();
                    if (!id) return;

                    id = String(id);

                    if (selectedCities.has(id)) return;

                    selectedCities.add(id);

                    render();

                    $(this).val(null).trigger('change');
                });

                // =====================
                // REMOVE CITY
                // =====================
                $(document).on('click', '.remove-city', function() {

                    const id = String($(this).data('id'));

                    selectedCities.delete(id);

                    render();
                });

                // =====================
                // RENDER
                // =====================
                function render() {

                    const container = $('#selected_cities');
                    const inputContainer = $('#city_inputs');

                    container.empty();
                    inputContainer.empty();

                    if (selectedCities.size === 0) {
                        container.html('<span class="text-muted">No cities selected yet</span>');
                        return;
                    }

                    selectedCities.forEach(id => {

                        const name = cityMap[id] ?? 'Unknown';

                        container.append(`
                <span class="badge bg-success-lt d-flex align-items-center gap-2">
                    ${name}
                    <i class="ti ti-x remove-city" data-id="${id}" style="cursor:pointer"></i>
                </span>
            `);

                        // ✅ ONLY SOURCE OF TRUTH FOR LARAVEL
                        inputContainer.append(`
                <input type="hidden" name="city_ids[]" value="${id}">
            `);
                    });
                }

            });
        </script>
    @endpush
@endsection
