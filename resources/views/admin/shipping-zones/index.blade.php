@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards space-y-4">

            {{-- ================= STATS ================= --}}
            <div class="col-12">
                <div class="row row-cards">

                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            <i class="ti ti-map fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $shippingZones->total() }}
                                        </div>
                                        <div class="text-secondary">
                                            Total Shipping Zones
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-success text-white avatar">
                                            <i class="ti ti-circle-check fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $shippingZones->where('is_active', true)->count() }}
                                        </div>
                                        <div class="text-secondary">
                                            Active Zones
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-danger text-white avatar">
                                            <i class="ti ti-circle-x fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $shippingZones->where('is_active', false)->count() }}
                                        </div>
                                        <div class="text-secondary">
                                            Inactive Zones
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">
                            Shipping Zones
                        </h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.shipping-zones.create') }}" class="btn btn-primary btn-3">
                                Create Zone
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-vcenter card-table">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Zone</th>
                                        <th>Cities</th>
                                        {{-- <th>Shipping Rules</th> --}}
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($shippingZones as $zone)
                                        <tr>

                                            {{-- ================= INDEX ================= --}}
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                            {{-- ================= ZONE NAME ================= --}}
                                            <td>
                                                <div class="fw-bold">
                                                    {{ $zone->name }}
                                                </div>
                                            </td>

                                            {{-- ================= CITIES PREVIEW ================= --}}
                                            <td>
                                                @php
                                                    $cities = $zone->cities;
                                                    $visible = $cities->take(3);
                                                    $remaining = $cities->count() - 3;
                                                @endphp

                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($visible as $city)
                                                        <span class="badge bg-success-lt">
                                                            {{ $city->name }}
                                                        </span>
                                                    @endforeach

                                                    @if ($remaining > 0)
                                                        <span class="badge bg-secondary-lt">
                                                            +{{ $remaining }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- ================= SHIPPING RULES ================= --}}

                                                @php
                                                    // $rules = $zone->shippingRules;
                                                    // $visibleRules = $rules->take(2);
                                                    // $remainingRules = $rules->count() - 2;
                                                @endphp

                                                {{-- <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($visibleRules as $rule)
                                                        <span class="badge bg-indigo-lt">
                                                            {{ $rule->name }}
                                                        </span>
                                                    @endforeach

                                                    @if ($remainingRules > 0)
                                                        <span class="badge bg-secondary-lt">
                                                            +{{ $remainingRules }}
                                                        </span>
                                                    @endif
                                                </div> --}}
                                            

                                            {{-- ================= STATUS ================= --}}
                                            <td>
                                                @if ($zone->is_active)
                                                    <span class="badge badge-sm bg-success-lt">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger-lt">Inactive</span>
                                                @endif
                                            </td>

                                            {{-- ================= DATE ================= --}}
                                            <td>
                                                {{ $zone->created_at->format('Y-m-d') }}
                                            </td>

                                            {{-- ================= ACTIONS ================= --}}
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                                        <i class="ti ti-dots-vertical fs-2"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        {{-- EDIT ZONE --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.shipping-zones.edit', $zone->id) }}">
                                                            <i class="ti ti-edit me-2"></i>
                                                            Edit Zone
                                                        </a>

                                                        {{-- MANAGE CHARGES --}}
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ route('admin.shipping-zones.rules', $zone->id) }}">
                                                            <i class="ti ti-currency-naira me-2"></i>
                                                            Manage Charges
                                                        </a>

                                                        <div class="dropdown-divider"></div>

                                                        {{-- DELETE --}}
                                                        <a class="dropdown-item text-danger delete-item"
                                                            href="{{ route('admin.shipping-zones.destroy', $zone->id) }}">
                                                            <i class="ti ti-trash me-2"></i>
                                                            Delete Zone
                                                        </a>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No shipping zones found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                        </div>
                    </div>

                    {{-- ================= PAGINATION ================= --}}
                    <div class="card-footer">
                        {{ $shippingZones->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
