@extends('admin.layout.app')

@section('contents')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-sm-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create State</h3>

                    <div class="card-actions">
                        <a href="{{ route('admin.states.index') }}" class="btn btn-primary btn-3">
                            <i class="ti ti-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.states.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label required">State Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   placeholder="e.g Lagos"
                                   required>

                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <label class="form-check form-switch">
                                <input type="checkbox"
                                       name="is_active"
                                       class="form-check-input"
                                       checked>
                                <span class="form-check-label">Active</span>
                            </label>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">
                                Create State
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
