@extends('admin.layout.app')
@section('contents')
    <div class="container-xl">
        <div class="row row-deck row-cards space-y-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create User</h3>
                        <div class="card-actions">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-3">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.role-user.store') }}" method="POST">
                            @csrf
                            <div class="row mb-5">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Name</label>
                                        <input type="name" value="{{ old('name') }}" class="form-control"
                                            name="name" required>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Email</label>
                                        <input type="email" value="{{ old('email') }}" class="form-control"
                                            name="email" required>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Password</label>
                                        <input type="password" value="{{ old('password') }}" class="form-control"
                                            name="password" required>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Password Confirmation</label>
                                        <input type="password" value="{{ old('password_confirmation') }}"
                                            class="form-control" name="password_confirmation" required>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Role</label>
                                        <select name="role_id" id="" class="form-control">
                                            <option value="">---select role---</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 text-end">
                                <button class="btn btn-primary" type="submit">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
