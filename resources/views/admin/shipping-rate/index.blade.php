
@extends('admin.layout.app')

@section('contents')

    <div class="container-xl">

        <div class="row row-deck row-cards space-y-4">

            {{-- ================= STATS ================= --}}

            <div class="col-12">

                <div class="row row-cards">

                    {{-- Total Rates --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            <i class="ti ti-route fs-2"></i>
                                        </span>
                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                            {{ $shippingRates->total() }}
                                        </div>

                                        <div class="text-secondary">
                                            Total Shipping Rates
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Active Rates --}}
                    <div class="col-sm-6 col-lg-3">

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
                                            {{ $activeRatesCount ?? 0 }}
                                        </div>

                                        <div class="text-secondary">
                                            Active Rates
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Inactive Rates --}}
                    <div class="col-sm-6 col-lg-3">

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
                                            {{ $inactiveRatesCount ?? 0 }}
                                        </div>

                                        <div class="text-secondary">
                                            Inactive Rates
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Shipping Methods --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">
                                        <span class="bg-warning text-white avatar">
                                            <i class="ti ti-truck-delivery fs-2"></i>
                                        </span>
                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                            {{ $shippingMethodsCount ?? 0 }}
                                        </div>

                                        <div class="text-secondary">
                                            Shipping Methods
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
                            Shipping Rates
                        </h3>

                        <div class="card-actions">

                            <a
                                href="{{ route('admin.shipping-rates.create') }}"
                                class="btn btn-primary btn-3"
                            >
                                <i class="ti ti-plus me-1"></i>
                                Create Shipping Rate
                            </a>

                        </div>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-vcenter card-table">

                                <thead>

                                    <tr>

                                        <th>#</th>

                                        <th>Store</th>

                                        <th>Shipping Method</th>

                                        <th>Route</th>

                                        <th>Order Amount</th>

                                        <th>Charge</th>

                                        <th>Status</th>

                                        <th>Created</th>

                                        <th class="w-1">Action</th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($shippingRates as $shippingRate)

                                        <tr>

                                            {{-- # --}}
                                            <td>
                                                {{ $shippingRates->firstItem() + $loop->index }}
                                            </td>


                                            {{-- STORE --}}
                                            <td>

                                                <div class="d-flex align-items-center">

                                                    <div class="avatar avatar-sm me-2">
                                                        <i class="ti ti-building-store"></i>
                                                    </div>

                                                    <div>

                                                        <div class="font-weight-medium">
                                                            {{ $shippingRate->store?->name ?? 'N/A' }}
                                                        </div>

                                                    </div>

                                                </div>

                                            </td>


                                            {{-- SHIPPING METHOD --}}
                                            <td>

                                                @if ($shippingRate->shippingMethod)

                                                    <div class="font-weight-medium">
                                                        {{ $shippingRate->shippingMethod->name }}
                                                    </div>

                                                    <div class="text-secondary small">
                                                        {{ $shippingRate->shippingMethod->min_days }}
                                                        -
                                                        {{ $shippingRate->shippingMethod->max_days }}
                                                        days
                                                    </div>

                                                @else

                                                    <span class="text-muted">
                                                        N/A
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- ROUTE --}}
                                            <td>

                                                <div class="d-flex align-items-center gap-1">

                                                    <span>
                                                        {{ $shippingRate->originZone?->name ?? 'N/A' }}
                                                    </span>

                                                    <i class="ti ti-arrow-right text-secondary"></i>

                                                    <span>
                                                        {{ $shippingRate->destinationZone?->name ?? 'N/A' }}
                                                    </span>

                                                </div>

                                            </td>


                                            {{-- ORDER AMOUNT --}}
                                            <td>

                                                <div class="font-weight-medium">

                                                    ₦{{ number_format($shippingRate->min_order_amount, 2) }}

                                                    <span class="text-secondary">
                                                        -
                                                    </span>

                                                    @if ($shippingRate->max_order_amount !== null)

                                                        ₦{{ number_format($shippingRate->max_order_amount, 2) }}

                                                    @else

                                                        <span class="text-secondary">
                                                            No limit
                                                        </span>

                                                    @endif

                                                </div>

                                            </td>


                                            {{-- CHARGE --}}
                                            <td>

                                                <span class="font-weight-medium">

                                                    ₦{{ number_format($shippingRate->charge, 2) }}

                                                </span>

                                            </td>


                                            {{-- STATUS --}}
                                            <td>

                                                @if ($shippingRate->is_active)

                                                    <span class="badge bg-success-lt">
                                                        <i class="ti ti-circle-check me-1"></i>
                                                        Active
                                                    </span>

                                                @else

                                                    <span class="badge bg-danger-lt">
                                                        <i class="ti ti-circle-x me-1"></i>
                                                        Inactive
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- CREATED --}}
                                            <td>

                                                <div>
                                                    {{ $shippingRate->created_at->format('M d, Y') }}
                                                </div>

                                                <div class="text-secondary small">
                                                    {{ $shippingRate->created_at->format('h:i A') }}
                                                </div>

                                            </td>


                                            {{-- ACTION --}}
                                            <td>

                                                <div class="dropdown">

                                                    <button
                                                        class="btn btn-sm btn-icon"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                    >
                                                        <i class="ti ti-dots-vertical"></i>
                                                    </button>

                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <a
                                                            href="{{ route('admin.shipping-rates.edit', $shippingRate) }}"
                                                            class="dropdown-item"
                                                        >
                                                            <i class="ti ti-edit me-2"></i>
                                                            Edit
                                                        </a>

                                                        <a class="dropdown-item text-danger delete-item"
                                                            href="{{ route('admin.shipping-rates.destroy', $shippingRate->id) }}">
                                                            <i class="ti ti-trash me-2"></i>
                                                            Delete
                                                        </a>
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="9" class="text-center py-5">

                                                <div class="empty">

                                                    <div class="empty-img">
                                                        <i class="ti ti-route fs-1 text-secondary"></i>
                                                    </div>

                                                    <p class="empty-title">
                                                        No shipping rates found
                                                    </p>

                                                    <p class="empty-subtitle text-secondary">
                                                        You have not created any shipping rates yet.
                                                    </p>

                                                    <div class="empty-action">

                                                        <a
                                                            href="{{ route('admin.shipping-rates.create') }}"
                                                            class="btn btn-primary"
                                                        >
                                                            <i class="ti ti-plus me-1"></i>
                                                            Create Shipping Rate
                                                        </a>

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- ================= PAGINATION ================= --}}

                    @if ($shippingRates->hasPages())

                        <div class="card-footer d-flex align-items-center">

                            <p class="m-0 text-secondary">
                                Showing
                                <strong>{{ $shippingRates->firstItem() }}</strong>
                                to
                                <strong>{{ $shippingRates->lastItem() }}</strong>
                                of
                                <strong>{{ $shippingRates->total() }}</strong>
                                rates
                            </p>

                            <div class="ms-auto">
                                {{ $shippingRates->links() }}
                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection

