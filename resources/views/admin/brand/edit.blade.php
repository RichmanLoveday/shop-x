@extends('admin.layout.app')

@section('contents')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Brand</h3>
                        <div class="card-actions">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-primary btn-3">
                                <i class="ti ti-arrow-left fs-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-3 space-y-3 mb-3">
                                <label for="preview-image">Brand Logo</label>
                                <x-input-image imageUpload="brandLogo" id="preview-image" name="brand_logo"
                                    previewImage="preview-brand-logo" :image="$brand->image" class="brand-logo" />
                                <x-input-error :messages="$errors->get('brand_logo')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label required">Name</label>
                                    <input type="name" value="{{ $brand->name }}" class="form-control" name="name"
                                        required>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-check form-switch form-switch-3">
                                    <input class="form-check-input" @checked($brand->is_active) id="status"
                                        type="checkbox" name="status">
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

    @push('scripts')
        <script>
            const $input = $('#brandLogo');
            const $preview = $('.preview-brand-logo');
            const $card = $('.brand-logo');

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
