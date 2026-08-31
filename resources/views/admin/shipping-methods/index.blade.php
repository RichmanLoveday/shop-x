@extends('admin.layout.app')

@section('contents')
    ```
    <div class="container-xl">

        <div class="row row-deck row-cards space-y-4">

            {{-- Statistics --}}
            <div class="col-12">

                <div class="row row-cards">

                    {{-- Total Methods --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">

                                        <span class="bg-primary text-white avatar">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">

                                                <path d="M5 12l14 0" />
                                                <path d="M5 12l4 -4" />
                                                <path d="M5 12l4 4" />

                                            </svg>

                                        </span>

                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                            {{ $shippingMethods['shippingMethods']->total() }}
                                        </div>

                                        <div class="text-secondary">
                                            Total Shipping Methods
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Active Methods --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">

                                        <span class="bg-success text-white avatar">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">

                                                <path d="M5 12l5 5l10 -10" />

                                            </svg>

                                        </span>

                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                            {{ $shippingMethods['activeMethods'] }}
                                        </div>

                                        <div class="text-secondary">
                                            Active Methods
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Inactive Methods --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">

                                        <span class="bg-warning text-white avatar">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">

                                                <path d="M12 9v4" />
                                                <path d="M12 17v.01" />
                                                <path
                                                    d="M10.24 3.58l-8.32 14a2 2 0 0 0 1.72 3h16.72a2 2 0 0 0 1.72 -3l-8.32 -14a2 2 0 0 0 -3.52 0z" />

                                            </svg>

                                        </span>

                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                          {{ $shippingMethods['inactiveMethods'] }}
                                        </div>

                                        <div class="text-secondary">
                                            Inactive Methods
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Available Rates --}}
                    <div class="col-sm-6 col-lg-3">

                        <div class="card card-sm">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-auto">

                                        <span class="bg-info text-white avatar">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">

                                                <path d="M3 12l3 -3l3 3l3 -3l3 3l3 -3l3 3" />
                                                <path d="M3 17l3 -3l3 3l3 -3l3 3l3 -3l3 3" />

                                            </svg>

                                        </span>

                                    </div>

                                    <div class="col">

                                        <div class="font-weight-medium">
                                           {{ $shippingMethods['configuredRates'] }}
                                        </div>

                                        <div class="text-secondary">
                                            Configured Routes
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Shipping Methods Table --}}
            <div class="col-12">

                <div class="card">

                    <div class="card-header">

                        <h3 class="card-title">
                            All Shipping Methods
                        </h3>

                        <div class="card-actions">

                            <a href="{{ route('admin.shipping-methods.create') }}" class="btn btn-primary btn-3">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">

                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />

                                </svg>

                                Create Shipping Method

                            </a>

                        </div>

                    </div>


                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-vcenter card-table">

                                <thead>

                                    <tr>

                                        <th>No.</th>

                                        <th>Name</th>

                                        <th>Code</th>

                                        <th>Delivery Time</th>

                                        <th>Routes</th>

                                        <th>Status</th>

                                        <th>Created</th>

                                        <th class="w-1"></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($shippingMethods['shippingMethods'] as $method)
                                        @php

                                            $statusColor = $method->is_active ? 'bg-success-lt' : 'bg-danger-lt';

                                            $statusLabel = $method->is_active ? 'Active' : 'Inactive';

                                        @endphp

                                        <tr>

                                            {{-- Number --}}
                                            <td>
                                                {{ $shippingMethods['shippingMethods']->firstItem() + $loop->index }}
                                            </td>


                                            {{-- Name --}}
                                            <td>

                                                <div class="font-weight-medium">
                                                    {{ $method->name }}
                                                </div>

                                            </td>


                                            {{-- Code --}}
                                            <td>

                                                <span class="badge bg-secondary-lt">
                                                    {{ $method->code }}
                                                </span>

                                            </td>


                                            {{-- Delivery Time --}}
                                            <td class="text-secondary">

                                                {{ $method->min_days }} -
                                                {{ $method->max_days }}
                                                Days

                                            </td>


                                            {{-- Routes --}}
                                            <td class="text-secondary">

                                                {{ $method->shippingRates->count() ?? 0 }}

                                            </td>


                                            {{-- Status --}}
                                            <td>

                                                <span class="badge badge-sm {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>

                                            </td>


                                            {{-- Created --}}
                                            <td class="text-secondary">

                                                {{ $method->created_at->format('d M Y') }}

                                            </td>


                                            {{-- Actions --}}
                                            <td>

                                                <div class="d-flex w-100 justify-content-between space-x-1">

                                                    <a href="{{ route('admin.shipping-methods.edit', $method->id) }}"
                                                        class="text-decoration-none">

                                                        <i class="ti ti-edit fs-1"></i>

                                                    </a>

                                                    <a href="{{ route('admin.shipping-methods.destroy', $method->id) }}"
                                                        class="text-decoration-none text-danger delete-item">

                                                        <i class="ti ti-trash fs-1"></i>

                                                    </a>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="8" class="text-center text-muted py-4">

                                                No shipping methods found.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{-- Pagination --}}
                        @if ($shippingMethods['shippingMethods']->hasPages())
                            <div class="card-footer">
                                {{ $shippingMethods['shippingMethods']->links() }}
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
    ```
@endsection
