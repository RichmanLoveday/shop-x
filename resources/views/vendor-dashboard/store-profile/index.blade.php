@extends('vendor-dashboard.layout.app')
@section('contents')
    <div class="container-xl">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Store Profile</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('vendor.shop-profile.update', auth('web')->user()->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-5">
                            <div class="col-md-6 space-y-2">
                                <label class="form-label" for="preview-image">Logo</label>
                                <x-input-image imageUpload="logo" id="preview-image" name="logo"
                                    previewImage="store-logo-preview" :image="$storeDetail->logo ?? ''" class="store-logo-avatar" />
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>
                            <div class="col-md-6 space-y-2">
                                <label class="form-label" for="preview-image">Banner</label>
                                <x-input-image imageUpload="banner" :image="$storeDetail->banner ?? ''" id="preview-image" name="banner"
                                    previewImage="store-banner-preview" class="store-banner-avatar" />
                                <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                            </div>

                            <div class="col-md-12 mt-5">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Name</label>
                                    <input type="text" value="{{ $storeDetail->name ?? '' }}" class="form-control"
                                        name="name" required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Phone</label>
                                    <input type="phone" value="{{ $storeDetail->phone ?? '' }}" class="form-control"
                                        name="phone" required>
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Email</label>
                                    <input type="email" value="{{ $storeDetail->email ?? '' }}" class="form-control"
                                        name="email" required>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address</label>
                                    <input type="text" value="{{ $storeDetail->address ?? '' }}" class="form-control"
                                        name="address" required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="short_desc" class="form-label required">Short Description</label>
                                    <textarea name="short_desc" cols="30" class="form-control" style="resize: none" rows="3">{{ $storeDetail->short_desc ?? '' }}</textarea>
                                    <x-input-error :messages="$errors->get('short_desc')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Long Description</label>
                                    <textarea name="long_desc" id="editor" cols="50" rows="10">{{ $storeDetail->long_desc ?? '' }}</textarea>
                                    <x-input-error :messages="$errors->get('long_desc')" class="mt-2" />
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const $storeBanner = $('#banner');
            const $storeBannerPreview = $('.store-banner-preview');
            const $storeBannerAvatar = $('.store-banner-avatar');

            const $storeLogo = $('#logo');
            const $storeLogoPreview = $('.store-logo-preview');
            const $storeLogoAvatar = $('.store-logo-avatar');


            $storeLogo.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $storeLogoPreview.attr('src', e.target.result);
                        $storeLogoAvatar.addClass('has-image');
                    };

                    reader.readAsDataURL(file);
                }
            });


            $storeBanner.on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $storeBannerPreview.attr('src', e.target.result);
                        $storeBannerAvatar.addClass('has-image');
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
