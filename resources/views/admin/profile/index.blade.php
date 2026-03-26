@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Profile</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <x-input-image id="preview-image" name="avatar" previewImage="preview-admin-image"
                                    :image="auth()->user()->avatar" class="admin-avatar" />
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Name</label>
                                        <input type="text" value="{{ auth('admin')->user()->name }}" class="form-control"
                                            name="name" placeholder="Enter Name">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label required">Email</label>
                                        <input type="text" value="{{ auth('admin')->user()->email }}"
                                            class="form-control" disabled name="email" placeholder="Email">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Account</button>
                    </form>
                </div>
            </div>


            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <form action="{{ route('admin.profile.password.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Current Password</label>
                                    <input type="password" required class="form-control" name="current_password"
                                        placeholder="Enter current password">
                                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Enter new password">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm password">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const $input = $('#image-upload');
            const $preview = $('.preview-admin-image');
            const $card = $('.admin-avatar');

            $input.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $preview.attr('src', e.target.result);
                        $card.addClass('has-image');
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
