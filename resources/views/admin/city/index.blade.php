@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards space-y-4">

            {{-- TOP STATS --}}
            <div class="col-12">
                <div class="row row-cards">

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            <i class="ti ti-map-pin fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $cities->total() ?? count($cities) }} Cities
                                        </div>
                                        <div class="text-secondary">Total locations</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar">
                                            <i class="ti ti-building fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $cities->where('is_active', 1)->count() }} Active
                                        </div>
                                        <div class="text-secondary">Available cities</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-red text-white avatar">
                                            <i class="ti ti-building-skyscraper fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $cities->where('is_active', 0)->count() }} Inactive
                                        </div>
                                        <div class="text-secondary">Disabled cities</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- TABLE --}}
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">All Cities</h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-3">
                                <i class="ti ti-plus"></i> Add City
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th class="w-1">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($cities as $city)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td class="fw-bold">
                                                {{ $city->name }}
                                            </td>

                                            <td>
                                                <span class="badge badge-sm bg-blue-lt">
                                                    {{ $city->state->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($city->is_active)
                                                    <span class="badge badge-sm bg-success-lt">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-danger-lt">Inactive</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $city->created_at->format('d M, Y') }}
                                            </td>

                                            <td>
                                                <div class="d-flex space-x-1">
                                                    <a href="{{ route('admin.cities.edit', $city->id) }}"
                                                        class="text-primary text-decoration-none">
                                                        <i class="ti ti-edit fs-2"></i>
                                                    </a>

                                                    <a href="{{ route('admin.cities.destroy', $city->id) }}"
                                                        class="text-danger delete-item text-decoration-none">
                                                        <i class="ti ti-trash fs-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No cities found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>

                    {{-- pagination if needed --}}
                    <div class="card-footer">
                        {{ $cities->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
