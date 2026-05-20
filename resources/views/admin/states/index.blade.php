@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">

        <div class="row row-deck row-cards space-y-4">

            {{-- HEADER STATS (optional but matches your style) --}}
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
                                        <div class="font-weight-medium">
                                            2 States
                                        </div>
                                        <div class="text-secondary">Nigeria Locations</div>
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
                                            {{-- {{ $states->sum(fn($s) => $s->cities_count) }} Cities --}}
                                            2 Cities
                                        </div>
                                        <div class="text-secondary">Across States</div>
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
                        <h3 class="card-title">All States</h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.states.create') }}" class="btn btn-primary btn-3">
                                <i class="ti ti-plus"></i>
                                Create State
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>State</th>
                                        <th>Cities</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($states as $state)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td class="fw-bold">
                                                {{ $state->name }}
                                            </td>

                                            <td>
                                                <span class="badge bg-blue-lt">
                                                    {{ $state->cities_count ?? $state->cities->count() }}
                                                </span>
                                            </td>

                                            <td>
                                                @if ($state->is_active)
                                                    <span class="badge bg-success-lt">Active</span>
                                                @else
                                                    <span class="badge bg-danger-lt">Inactive</span>
                                                @endif
                                            </td>

                                            <td class="text-secondary">
                                                {{ $state->created_at->format('d M, Y') }}
                                            </td>

                                            <td>
                                                <div class="d-flex space-x-1">

                                                    <a href="{{ route('admin.states.edit', $state->id) }}"
                                                        class="text-primary text-decoration-none">
                                                        <i class="ti ti-edit fs-2"></i>
                                                    </a>

                                                    <a href="{{ route('admin.states.destroy', $state->id) }}"
                                                        class="text-danger text-decoration-none delete-item">
                                                        <i class="ti ti-trash fs-2"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No states found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $states->links() }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
