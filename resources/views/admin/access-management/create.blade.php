@extends('admin.layout.app')
@section('contents')
    <div class="container-xl">
        <div class="row row-deck row-cards space-y-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Role</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.role.create') }}" class="btn btn-primary btn-3">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Add new
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.role.store') }}" method="POST">
                            @csrf
                            <div class="row mb-5">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Role Name</label>
                                        <input type="name" value="{{ $storeDetail->phone ?? '' }}" class="form-control"
                                            name="name" required>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>

                                @foreach ($permissions as $groupName => $permission)
                                    <div class="col-md-4 mb-3">
                                        <h3>{{ $groupName }}</h3>
                                        @foreach ($permission as $item)
                                            <label for="{{ $item->name }}" class="form-check">
                                                <input type="checkbox" class="form-check-input" id="{{ $item->name }}"
                                                    value="{{ $item->id }}" name="permissions[]">
                                                <span class="form-check-label">{{ $item->name }}</span>
                                            </label>
                                            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div class="w-100 text-end">
                                <button class="btn btn-primary" type="submit">Create Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
