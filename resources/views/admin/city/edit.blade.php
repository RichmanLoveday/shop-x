@extends('admin.layout.app')

@section('contents')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit City</h3>

                        <div class="card-actions">
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-primary btn-3">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.cities.update', $city->id) }}">
                            @csrf
                            @method('PUT')

                            {{-- State --}}
                            <div class="mb-3">
                                <label class="form-label required">State</label>

                                <select name="state_id" class="form-select select2" required>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state_id', $city->state_id) == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('state_id')" />
                            </div>

                            {{-- City Name --}}
                            <div class="mb-3">
                                <label class="form-label required">City Name</label>

                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $city->name) }}" required>

                                <x-input-error :messages="$errors->get('name')" />
                            </div>

                            {{-- Active --}}
                            <div class="mb-4">
                                <label class="form-check form-switch">
                                    <input type="checkbox" name="is_active" class="form-check-input"
                                        {{ $city->is_active ? 'checked' : '' }}>
                                    <span class="form-check-label">Active</span>
                                </label>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary">
                                    Update City
                                </button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
