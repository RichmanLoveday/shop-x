@extends('frontend.dashboard.dashboard-app')
@section('dashboard_contents')
    <div class="" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
        <div class="card">
            <div class="card-header p-0">
                <h5>Account Details</h5>
            </div>
            <div class="card-body p-0 ">
                <div class=" mb-50">
                    <p>You can edit your account detail here </p>
                    <form method="post" name="enq" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-input-image id="preview-image" name="avatar" :image="auth()->user()->avatar" />

                        <div class="row mt-30">
                            <div class="form-group col-md-12">
                                <label>Name <span class="required">*</span></label>
                                <input required="" class="form-control" name="name" type="text"
                                    value="{{ auth('web')->user()->name }}" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-group col-md-12">
                                <label>Email Address <span class="required">*</span></label>
                                <input required="" class="form-control" name="email" type="email"
                                    value="{{ auth('web')->user()->email }}" disabled />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-fill-out submit font-weight-bold" value="Submit">Save
                                    Change</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div>
                    <p>You can can change your password here </p>
                    <form method="post" name="enq" action="{{ route('profile.change-password') }}">
                        @csrf
                        @method('PUT')
                        <div class="row mt-30">
                            <div class="form-group col-md-12">
                                <label>Current Password <span class="required">*</span></label>
                                <input required="" class="form-control" name="current_password" type="password" />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>New Password <span class="required">*</span></label>
                                <input required="" class="form-control" name="password" type="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>Confirm Password <span class="required">*</span></label>
                                <input required="" class="form-control" name="password_confirmation" type="password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-fill-out submit font-weight-bold" value="Submit">Save
                                    Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // $(document).ready(function() {
            //     $.uploadPreview({
            //         input_field: "#image-upload", // Default: .image-upload
            //         preview_box: "#image-preview", // Default: .image-preview
            //         label_field: "#image-label", // Default: .image-label
            //         label_default: "Choose File", // Default: Choose File
            //         label_selected: "Change File", // Default: Change File
            //         no_label: false // Default: false
            //     });
            // });

            const $input = $('#image-upload');
            const $preview = $('#preview-image');
            const $card = $('.upload-card');

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
