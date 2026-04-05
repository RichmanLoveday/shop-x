@extends('admin.layout.app')

@section('contents')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Tag</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-primary btn-3">
                                <i class="ti ti-arrow-left fs-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Name</label>
                                    <input type="name" value="{{ $tag->name }}" class="form-control" name="name"
                                        required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-check form-switch form-switch-3">
                                    <input class="form-check-input" id="status" type="checkbox"
                                        @checked($tag->is_active) name="status">
                                    <span class="form-check-label">Active</span>
                                </label>
                            </div>

                            <div class="w-100 text-end">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
