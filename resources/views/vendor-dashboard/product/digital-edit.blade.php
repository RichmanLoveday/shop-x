@extends('vendor-dashboard.layout.app')
@section('contents')
    @push('styles')
        <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
        <style>
            /* UPLOADER BOX */
            .image-uploader-box {
                border: 2px dashed var(--tblr-border-color);
                padding: 40px;
                text-align: center;
                cursor: pointer;
                background: var(--tblr-bg-surface);
                transition: 0.3s;
            }

            .image-uploader-box:hover {
                border-color: var(--tblr-primary);
                background: var(--tblr-bg-surface-secondary);
            }

            .upload-placeholder i {
                font-size: 30px;
                color: var(--tblr-muted);
            }

            .upload-placeholder p {
                margin-top: 10px;
                color: var(--tblr-muted);
                font-size: 14px;
            }

            /* PREVIEW GRID */
            .image-preview-container {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
                margin-top: 15px;
            }

            /* IMAGE CARD */
            .image-card {
                position: relative;
                width: 100%;
                height: 120px;
                background: var(--tblr-bg-surface);
                border: 1px solid var(--tblr-border-color);
                overflow: hidden;
            }

            /* IMAGE */
            .image-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* UPLOADING STATE */
            .image-card.uploading {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 10px;
            }

            /* LOADER */
            .image-loader {
                display: flex;
                gap: 4px;
            }

            .image-loader span {
                width: 4px;
                height: 16px;
                background: #1db954;
                animation: bounce 1s infinite ease-in-out;
            }

            .image-loader span:nth-child(2) {
                animation-delay: 0.2s;
            }

            .image-loader span:nth-child(3) {
                animation-delay: 0.4s;
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: scaleY(0.5);
                }

                50% {
                    transform: scaleY(1.2);
                }
            }

            /* TEXT */
            .uploading-text {
                font-size: 12px;
                color: var(--tblr-muted);
            }

            /* DELETE ICON */
            .image-remove {
                position: absolute;
                z-index: 100;
                top: 6px;
                right: 6px;
                background: rgba(0, 0, 0, 0.6);
                color: #fff;
                padding: 4px;
                cursor: pointer;
            }


            /* Dragging ghost */
            .dragging {
                opacity: 0.5;
            }

            /* Selected item */
            .drag-chosen {
                transform: scale(1.03);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
                z-index: 10;
            }

            .file-preview-container {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 15px;
            }

            /* FULL WIDTH */
            .file-card {
                width: 100%;
                padding: 16px 18px;

                background: var(--tblr-bg-surface);
                border: 1px solid var(--tblr-border-color);

                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 15px;

                transition: background 0.2s ease, box-shadow 0.2s ease;
            }

            /* Hover = subtle elevation */
            .file-card:hover {
                background: var(--tblr-bg-surface-secondary);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            }

            /* LEFT SIDE */
            .file-info {
                flex: 1;
                overflow: hidden;
            }

            .file-name {
                font-size: 14px;
                color: var(--tblr-body-color);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .file-size {
                font-size: 12px;
                color: var(--tblr-muted);
            }

            /* RIGHT SIDE */
            .file-meta {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            /* PROGRESS BAR */
            .file-progress {
                width: 200px;
                height: 6px;
                background: var(--tblr-border-color);
                position: relative;
            }

            .file-progress-bar {
                height: 100%;
                width: 0%;
                background: #1db954;
                transition: width 0.2s ease;
            }

            /* PERCENT TEXT */
            .file-percentage {
                font-size: 12px;
                color: var(--tblr-muted);
                min-width: 45px;
                text-align: right;
                font-weight: 500;
            }

            /* REMOVE ICON */
            /* REMOVE BUTTON (clean + subtle) */
            .file-remove {
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;

                border-radius: 6px;
                background: transparent;
                color: var(--tblr-muted);

                cursor: pointer;
                transition: all 0.2s ease;
            }

            /* Hover effect */
            .file-remove:hover {
                background: rgba(255, 0, 0, 0.08);
                color: var(--tblr-danger);
            }

            /* Icon sizing */
            .file-remove i {
                font-size: 16px;
            }


            .file-progress {
                width: 220px;
                height: 6px;
                background: rgba(0, 0, 0, 0.05);
                overflow: hidden;
                position: relative;
            }

            /* PROGRESS BAR */
            .file-progress-bar {
                height: 100%;
                width: 0%;

                background: linear-gradient(90deg,
                        #1db954,
                        #1ed760);

                transition: width 0.25s ease;

                position: relative;
            }

            /* subtle shine animation */
            .file-progress-bar::after {
                content: "";
                position: absolute;
                top: 0;
                left: -40%;
                width: 40%;
                height: 100%;

                background: rgba(255, 255, 255, 0.4);
                transform: skewX(-20deg);

                animation: shimmer 1.2s infinite;
            }


            .file-progress-bar.stop-animation::after {
                animation: none !important;
                display: none;
            }

            /* smooth status area */
            .file-status {
                margin-top: 10px;
                font-size: 13px;
                color: var(--tblr-muted);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            /* spinner */
            .processing-spinner {
                width: 16px;
                height: 16px;
                border: 2px solid rgba(29, 185, 84, 0.15);
                border-top-color: #1db954;
                border-radius: 50%;
                animation: spinSmooth 0.8s linear infinite;
            }

            /* completed badge */
            .upload-complete-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-size: 13px;
                font-weight: 600;
                color: #1db954;
            }

            /* completed text */
            .completed-text {
                font-size: 13px;
                font-weight: 500;
                color: #1db954;
            }

            /* failed text */
            .failed-text {
                font-size: 13px;
                font-weight: 500;
                color: #dc3545;
            }

            /* processing card subtle effect */
            .processing-state {
                border-color: rgba(29, 185, 84, 0.35);
            }

            /* completed card */
            .completed-state {
                border-color: rgba(29, 185, 84, 0.45);
            }

            /* smooth rotation */
            @keyframes spinSmooth {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* shimmer effect */
            @keyframes shimmer {
                0% {
                    left: -40%;
                }

                100% {
                    left: 120%;
                }
            }
        </style>
    @endpush
    <div class="container-xl">
        <form enctype="multipart/form-data" id="product_form">
            @csrf
            <div class="row">
                <div class="col-md-8 space-y-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4">

                                {{-- Name --}}
                                <div class="col-md-12">
                                    <div class="">
                                        <label class="form-label required">Name</label>
                                        <input type="text" name="name" value="{{ $product->name }}"
                                            class="form-control" required>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>


                            </div>

                            {{-- Short Description --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" id="short-description" cols="50" rows="10">{{ $product->short_description }}</textarea>
                                    <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Content</label>
                                    <textarea name="long_description" class="form-control" id="long-description" cols="50" rows="10" required>{{ $product->description }}</textarea>
                                    <x-input-error :messages="$errors->get('long_description')" class="mt-2" />
                                </div>
                            </div>


                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="thumbnail" class="form-label required">Thumbnail</label>
                                    <x-input-image imageUpload="thumbnail" id="preview-image" name="thumbnail"
                                        previewImage="preview-thumbnail" :image="$product->thumbnail" class="thumbnail" />

                                    {{-- <x-input-image name="avatar" imageUpload="thumbnail" id="preview-image"
                                    previewImage="preview-user-image" :image="auth()->user()->avatar" class="user-avatar" /> --}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-5">

                                {{-- SKU --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" value="{{ $product->sku }}"
                                            class="form-control">
                                        <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                    </div>
                                </div>


                                {{-- Price --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" name="price" value="{{ $product->price }}"
                                            class="form-control">
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Special Price</label>
                                        <input type="text" name="special_price" value="{{ $product->special_price }}"
                                            class="form-control">
                                        <x-input-error :messages="$errors->get('special_price')" class="mt-2" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">From Date</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-calendar-event fs-2"></i>
                                            </span>
                                            <input class="form-control" placeholder="Select a date" id="from_date"
                                                value="{{ old('from_date') ?? $product->special_price_start }}"
                                                name="from_date">
                                            <x-input-error :messages="$errors->get('from_date')" class="mt-2" />
                                        </div>
                                        {{-- <input required="" id="date" name="dob" class="datepicker" /> --}}
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">To Date</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-calendar-event fs-2"></i>
                                            </span>
                                            <input class="form-control" placeholder="Select a date" id="end_date"
                                                value="{{ old('end_date') ?? $product->special_price_end }}"
                                                name="end_date">
                                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 ">
                                            <label for="manage-stock" class="form-check">
                                                <input id="manage-stock" name="manage_stock" class="form-check-input"
                                                    type="checkbox" {{ $product->manage_stock == 'yes' ? 'checked' : '' }}>
                                                <span class="form-check-label">Manage Stock</span>
                                            </label>
                                            <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                                        </div>
                                    </div>


                                    <div class="col-md-6"
                                        style="display: {{ $product->manage_stock == 'yes' ? 'block' : 'none' }}"
                                        id="quantity-field">
                                        <div class="mb-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="text" name="quantity"
                                                value="{{ old('quantity') ?? $product->qty }}" class="form-control">
                                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                        </div>
                                    </div>

                                </div>


                                <div class="row"
                                    style="display: {{ $product->manage_stock == 'yes' ? 'block' : 'none' }}"
                                    id="stock-status-field">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3>Stock Status</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="inStock" class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="stock_status" value="in_stock" id="inStock"
                                                            {{ old('stock_status') == 'in_stock' || $product->stock_status == 1 ? 'checked' : '' }}>
                                                        <span class="form-check-label">In Stock</span>
                                                    </label>
                                                    <label for="outOfStock" class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="stock_status" value="out_of_stock" id="outOfStock"
                                                            {{ old('stock_status') == 'out_of_stock' || $product->stock_status == 0 ? 'checked' : '' }}>
                                                        <span class="form-check-label">Out of Stock</span>
                                                    </label>
                                                    <x-input-error :messages="$errors->get('stock_status')" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="product-images" class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Product Files</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">

                                    <div id="digitalUploader" class="image-uploader-box">
                                        <div class="upload-placeholder">
                                            <i class="ti ti-file-upload"></i>
                                            <p>Drop digital files here</p>
                                        </div>
                                    </div>

                                    <div id="digitalPreviewContainer" class="file-preview-container">
                                        @foreach ($product->files as $file)
                                            @php
                                                $status = $file->status->value;
                                            @endphp

                                            <div class="file-card dz-preview
                                                {{ $status === 'processing' ? 'processing-state' : '' }}
                                                {{ $status === 'completed' ? 'completed-state' : '' }}
                                                {{ $status === 'already_processed' ? 'completed-state' : '' }}
                                            "data-file-id="{{ $file->id }}"
                                                data-status="{{ $status }}"
                                                data-product-id="{{ $file->product_id }}">

                                                <div class="file-info">
                                                    <div class="file-name" data-dz-name>{{ $file->filename }}</div>
                                                    <div class="file-size" data-dz-size>
                                                        {{ number_format($file->size / 1024, 2) }} KB</div>

                                                    {{-- STATUS --}}
                                                    <div class="file-status">

                                                        @if ($status === 'processing')
                                                            <span class="processing-spinner"></span>
                                                            Processing file...
                                                        @elseif ($status === 'completed')
                                                            <span class="completed-text">
                                                                Ready for use
                                                            </span>
                                                        @elseif ($status === 'already_processed')
                                                            <span class="completed-text">
                                                                Already processed
                                                            </span>
                                                        @elseif ($status === 'failed')
                                                            <span class="failed-text">
                                                                Upload failed
                                                            </span>
                                                        @else
                                                            <span>
                                                                Preparing upload...
                                                            </span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="file-meta">

                                                    <div class="file-progress">
                                                        <div class="file-progress-bar
                                                            {{ in_array($status, ['completed', 'processing', 'already_processed']) ? 'stop-animation' : '' }}"
                                                            data-dz-uploadprogress
                                                            style="width: {{ in_array($status, ['completed', 'processing', 'already_processed']) ? '100%' : '0%' }}">
                                                        </div>
                                                    </div>

                                                    <div class="file-percentage">
                                                        @if ($status === 'completed')
                                                            <span class="upload-complete-badge">
                                                                <i class="ti ti-circle-check"></i>
                                                                Completed
                                                            </span>
                                                        @else
                                                            <span class="dz-upload-percent">0%</span>
                                                        @endif
                                                    </div>

                                                    <div class="file-remove delete-file"
                                                        data-file-id="{{ $file->id }}" data-dz-remove>
                                                        <i class="ti ti-xbox-x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 space-y-3">
                    {{-- <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Store</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="store_id" id="select_store" class="form-control select2" required>
                                    <option value="">--- Select Store ---</option>
                                    <option value="{{ $product->store_id }}" selected>{{ $product->store->name }}
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                            </div>
                        </div>
                    </div> --}}

                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Category</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3 space-y-3">
                                <input type="text" class="form-control" name="" id="category-search"
                                    placeholder="Search categories...">
                                <div class="overflow-auto px-4 py-2" style="max-height: 400px;">
                                    <ul class="list-unstyled" id="category-tree">
                                        @foreach ($categories as $category)
                                            <li>
                                                <label class="form-check category-wrapper">
                                                    <input type="checkbox" class="form-check-input category-check"
                                                        name="categories[]" value="{{ $category->id }}"
                                                        @checked(in_array($category->id, $product->categories->pluck('id')->toArray()))>
                                                    <span
                                                        class="form-check-label category-label">{{ $category->name }}</span>
                                                </label>

                                                @if ($category->children && $category->children->count() > 0)
                                                    <ul class="list-unstyled ms-4 mt-2">
                                                        @foreach ($category->children as $child)
                                                            <li>
                                                                <label class="form-check category-wrapper">
                                                                    <input type="checkbox"
                                                                        class="form-check-input category-check"
                                                                        name="categories[]" value="{{ $child->id }}"
                                                                        @checked(in_array($child->id, $product->categories->pluck('id')->toArray()))>
                                                                    <span
                                                                        class="form-check-label category-label">{{ $child->name }}</span>
                                                                </label>

                                                                @if ($child->children && $child->children->count() > 0)
                                                                    <ul class="list-unstyled ms-4 mt-2">
                                                                        @foreach ($child->children as $grandChild)
                                                                            <li>
                                                                                <label class="form-check category-wrapper">
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input category-check"
                                                                                        name="categories[]"
                                                                                        value="{{ $grandChild->id }}"
                                                                                        @checked(in_array($grandChild->id, $product->categories->pluck('id')->toArray()))>
                                                                                    <span
                                                                                        class="form-check-label category-label">{{ $grandChild->name }}</span>
                                                                                </label>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif

                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Brand</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="brand_id" id="select_brand" class="form-control select2" required>
                                    <option value="">--- Select Brand ---</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Is Featured</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="is_featured" class="form-control select2" required>
                                    <option value="">--- Select Featured ---</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                            </div>
                        </div>
                    </div> --}}

                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Is Featured</h3>
                        </card>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check form-switch form-switch-3">
                                        <input class="form-check-input" id="status" type="checkbox"
                                            name="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                                        <span class="form-check-label">Enable</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Label</h3>
                        </card>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3 ">
                                    <label for="hot" class="form-check">
                                        <input id="hot" class="form-check-input" type="checkbox" name="is_hot"
                                            @checked($product->is_hot)>
                                        <span class="form-check-label">Hot</span>
                                    </label>
                                    <label for="new" class="form-check">
                                        <input id="new" class="form-check-input" type="checkbox" name="is_new"
                                            @checked($product->is_new)>
                                        <span class="form-check-label">New</span>
                                    </label>
                                    <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Tags</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="tags[]" class="form-control select2" id="select_tag" multiple="multiple">
                                    <option value="">--- Select Tag ---</option>
                                    @foreach ($product->tags as $item)
                                        <option value="{{ $item->id }}" @selected(in_array($item->id, $product->tags->pluck('id')->toArray()))>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('tag_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <card class="card-header">
                            <h3 class="card-title">Status</h3>
                        </card>
                        <div class="card-body">
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="">--- Select Status ---</option>
                                    @foreach ($statuses as $item)
                                        <option value="{{ $item->value }}" @selected($product->status == $item->value)>
                                            {{ $item->label() }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="card sticky-top">
                        <div class="card-body">
                            <div class="w-100 text-center">
                                <button class="btn btn-primary w-100" type="submit">Update Product</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            Dropzone = window.Dropzone || {};
            Dropzone.autoDiscover = false;
        </script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

        <script>
            if (Dropzone.instances.length) {
                Dropzone.instances.forEach(dz => dz.destroy());
            }

            $(document).ready(function() {
                // $('#select_store').select2({
                //     placeholder: 'Search for stores...',
                //     minimumInputLength: 2,
                //     ajax: {
                //         url: route('vendor.stores.search'),
                //         dataType: 'json',
                //         delay: 250,
                //         data: function(params) {
                //             return {
                //                 name: params.term
                //             };
                //         },
                //         processResults: function(data) {
                //             return {
                //                 results: data.stores.map(function(store) {
                //                     return {
                //                         id: store.id,
                //                         text: store.name
                //                     };
                //                 })
                //             };
                //         },
                //         cache: true
                //     }
                // });


                // $('#select_store').on('select2:select', function(e) {
                //     let data = e.params.data;

                //     // Create a real option if it doesn't exist
                //     let option = new Option(data.text, data.id, true, true);
                //     $(this).append(option).trigger('change');
                // });


                // $('#select_brand').select2({
                //     placeholder: 'Search for brands...',
                //     minimumInputLength: 2, // avoid unnecessary API calls
                //     ajax: {
                //         url: route('vendor.brands.search'),
                //         dataType: 'json',
                //         delay: 250, // debounce for performance
                //         data: function(params) {
                //             return {
                //                 name: params.term
                //             };
                //         },
                //         processResults: function(data) {
                //             const brands = data.brands;
                //             // console.log(brands);
                //             return {
                //                 results: brands.map(function(store) {
                //                     return {
                //                         id: store.id,
                //                         text: store.name
                //                     };
                //                 })
                //             };
                //         },
                //         cache: true
                //     }
                // });


                // select2 for tags with multiple selection
                $('#select_tag').select2({
                    placeholder: 'Search for tags...',
                    minimumInputLength: 2, // avoid unnecessary API calls
                    ajax: {
                        url: route('vendor.tags.search'),
                        dataType: 'json',
                        delay: 250, // debounce for performance
                        data: function(params) {
                            return {
                                name: params.term
                            };
                        },
                        processResults: function(data) {
                            const tags = data.tags;
                            // console.log(tags);
                            return {
                                results: tags.map(function(store) {
                                    return {
                                        id: store.id,
                                        text: store.name
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });


                // Handle category checkbox changes
                $('.category-check').on('change', function() {
                    const isChecked = $(this).is(':checked');
                    const parentLi = $(this).closest('li');

                    // Downward: check/uncheck children
                    parentLi.find('ul input.category-check').prop({
                        checked: isChecked,
                        indeterminate: false
                    });

                    // Upward: update parent state
                    updateParent($(this));
                });


                // Recursive function to update parent checkbox state
                function updateParent(element) {
                    const parentUl = element.closest('ul').closest('li');

                    if (parentUl.length) {
                        const allChildren = parentUl.find('> ul > li input.category-check');
                        const checkedChildren = allChildren.filter(':checked');

                        const parentCheckbox = parentUl.children('label').find('input.category-check');

                        if (checkedChildren.length === 0) {
                            parentCheckbox.prop({
                                checked: false,
                                indeterminate: false
                            });
                        } else if (checkedChildren.length === allChildren.length) {
                            parentCheckbox.prop({
                                checked: true,
                                indeterminate: false
                            });
                        } else {
                            parentCheckbox.prop({
                                checked: false,
                                indeterminate: true
                            });
                        }

                        // recursive upward
                        updateParent(parentCheckbox);
                    }
                }


                $('#category-search').on('input', function() {
                    const query = $(this).val().toLowerCase().trim();

                    $('#category-tree li').each(function() {
                        const label = $(this).find('> label > .category-label').text().toLowerCase();

                        // Show if label matches query
                        if (label.includes(query)) {
                            $(this).show();
                            $(this).parents('li').show(); // show parents
                        } else {
                            $(this).hide();
                        }


                        // if query is empty
                        if (query === '') {
                            $("#category-tree li").show();
                        }
                    });
                });


                // handle manage stock toggle
                $('#manage-stock').on('change', function(el) {
                    // console.log(el);
                    if ($(this).is(':checked')) {
                        // show quantity and stock status fields
                        $('#quantity-field').show();
                        $('#stock-status-field').show();
                    } else {
                        // hide quantity and stock status fields
                        $('#quantity-field').hide();
                        $('#stock-status-field').hide();
                    }
                });

                // Extra safety: if user manually clears input
                $('#from_date').on('input', function() {
                    if (!$(this).val()) {
                        $('#end_date').val('').prop('disabled', true);
                        if (toPicker) {
                            toPicker.clearSelection();
                        }
                    }
                });



                const $input = $('#thumbnail');
                const $preview = $('.preview-thumbnail');
                const $card = $('.thumbnail');

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


                // submit form with ajax
                $('#product_form').on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = new FormData(form[0]);
                    let type = "{{ \App\Enums\ProductType::DIGITAL }}";
                    let url = route('vendor.products.update', [type, {{ $product->id }}]);

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                // notyf.success(response.message || 'Product updated successfully');
                                window.location.href = response.redirectUrl;
                            } else {
                                notyf.error(response.message || 'Failed to update product');
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                console.log(errors);

                                // Display new errors
                                $.each(errors, function(key, value) {
                                    notyf.error(errors[key][0]);
                                });
                            }

                            if (xhr.status === 500) {
                                notyf.error('Server error while updating product');
                            }

                            if (xhr.status == 419) {
                                notyf.error(
                                    'Session expired. Please refresh the page and try again.');
                            }
                        }
                    });
                });


                let previewTemplate = `
                    <div class="file-card dz-preview">

                        <div class="file-info">
                            <div class="file-name" data-dz-name></div>
                            <div class="file-size" data-dz-size></div>

                            <!-- Status Area -->
                            <div class="file-status">
                                <span class="processing-spinner"></span>
                                Preparing upload...
                            </div>
                        </div>

                        <div class="file-meta">

                            <div class="file-progress">
                                <div class="file-progress-bar" data-dz-uploadprogress></div>
                            </div>

                            <div class="file-percentage">
                                <span class="dz-upload-percent">0%</span>
                            </div>

                            <div class="file-remove" data-dz-remove>
                                <i class="ti ti-xbox-x"></i>
                            </div>

                        </div>

                    </div>
                `;

                let type = "{{ \App\Enums\ProductType::DIGITAL }}";
                Dropzone.autoDiscover = false;

                let digitalDropzone = new Dropzone("#digitalUploader", {
                    url: route('vendor.product.digital.file-upload', [type, {{ $product->id }}]),

                    paramName: "file",
                    maxFilesize: 1024,
                    acceptedFiles: ".zip,.pdf,.mp4,.mp3",

                    chunking: true,
                    forceChunking: true,
                    chunkSize: 2 * 1024 * 1024,
                    parallelChunkUploads: true,
                    retryChunks: true,
                    retryChunksLimit: 3,
                    acceptedFiles: "images/*, application/pdf, video/*, audio/*, application/*",
                    previewTemplate: previewTemplate,
                    previewsContainer: "#digitalPreviewContainer",

                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    init: function() {

                        this.on("addedfile", function(file) {
                            let container = $("#digitalPreviewContainer");
                            let preview = $(file.previewElement);

                            preview.detach();
                            container.prepend(preview);
                        });

                        // Update percentage manually
                        this.on("uploadprogress", function(file, progress) {
                            let percent = Math.round(progress);
                            let el = $(file.previewElement);

                            el.find(".dz-upload-percent")
                                .text(percent + "%");

                            el.find(".file-status")
                                .html(`
                            <span class="processing-spinner"></span>
                            Uploading...
                            `);
                        });

                        // When upload finishes
                        this.on("success", function(file, response) {

                            let fileId = response?.digitalFile?.id;
                            let productId = response?.digitalFile?.product_id;
                            let el = $(file.previewElement);


                            if (response?.digitalFile && response?.digitalFile?.id) {
                                el.find(".file-remove")
                                    .addClass("delete-file")
                                    .attr("data-file-id", response.digitalFile.id);
                            }

                            checkStatus(productId, fileId, el);
                        });

                        this.on("error", function(file) {
                            let el = $(file.previewElement);

                            el.find(".file-status")
                                .html(`
                                    <span class="failed-text">
                                        Upload failed
                                    </span>
                                `);

                            notyf.error("Upload failed");
                        });
                    }
                });
            });


            $(".dz-preview").each(function() {

                let el = $(this);
                let productId = el.data("product-id");
                let fileId = el.data("file-id");
                let status = el.data("status");

                console.log(status, productId, fileId);

                // only poll if still processing
                if (status === "processing") {
                    checkStatus(productId, fileId, el);
                }
            });


            function updateFileUI(el, status) {

                const bar = el.find(".file-progress-bar");
                const percent = el.find(".dz-upload-percent");
                const fileStatus = el.find(".file-status");

                bar.css("width", "100%")
                    .addClass("stop-animation");

                if (status === "processing") {

                    percent.text("100%");
                    fileStatus.html(`
                    <span class="processing-spinner"></span>
                    Processing file...
                `);

                    el.addClass("processing-state");

                } else if (status === "completed") {

                    percent.html(`
                    <span class="upload-complete-badge">
                        <i class="ti ti-circle-check"></i>
                        Completed
                    </span>
                `);

                    fileStatus.html(`
                    <span class="completed-text">
                        Ready for use
                    </span>
                `);

                    el.removeClass("processing-state")
                        .addClass("completed-state");

                } else if (status === "already_processed") {

                    fileStatus.html(`
                    <span class="completed-text">
                        Already processed
                    </span>
                `);
                } else if (status === 'failed') {
                    fileStatus.html(`
                         <span class="failed-text">
                            Upload failed
                        </span>
                    `);
                }
            }



            function checkStatus(productId = null, fileId = null, el) {

                let interval = setInterval(() => {

                    if (!fileId) return;

                    $.get(route('vendor.product.digital.status', [productId, fileId]), function(response) {

                        updateFileUI(el, response.status);

                        // STOP polling when finished
                        if (
                            response.status === "completed" ||
                            response.status === "failed" ||
                            response.status === "already_processed"
                        ) {
                            clearInterval(interval);
                        }
                    });

                }, 2000);
            }


            $(document).on('click', '.delete-file', function() {
                const button = $(this);
                const fileId = button.attr('data-file-id');
                const productId = "{{ $product->id }}";


                // prevent multible deleting
                if (button.hasClass('deleting')) {
                    return;
                }

                button.addClass('deleting');

                button.html(`
                    <span class="processing-spinner"></span>
                `);


                $.ajax({
                    method: "DELETE",
                    url: route('vendor.product.digital.product.file.destroy', [productId, fileId]),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === true) {
                            button.closest('.file-card').fadeOut(300, function() {
                                $(this).remove();
                            });

                            notyf.success(response.message);
                        } else {
                            restoreDeleteButton(button);
                            notyf.error("Failed to delete file");
                        }
                    },
                    error: function(xhr, status, error) {
                        restoreDeleteButton(button);
                        notyf.error("Something went wrong");
                    }
                });
            });


            function restoreDeleteButton(button) {
                button.removeClass('deleting');

                button.html(`
                    <i class="ti ti-xbox-x"></i>
                `);
            }

            let sortable;

            function enableSortable() {
                if (sortable) {
                    sortable.destroy(); // prevent duplicate init
                }

                sortable = new Sortable(document.getElementById('imagePreviewContainer'), {
                    animation: 150,
                    ghostClass: 'dragging',
                    chosenClass: 'drag-chosen',

                    onEnd: function() {
                        updateImageOrder();
                    }
                });
            }

            function updateImageOrder() {
                let order = [];

                $('#imagePreviewContainer .image-card').each(function(index) {
                    order.push({
                        id: $(this).data('id'),
                        position: index + 1
                    });
                });

                let productId = {{ $product->id }};
                let type = "{{ \App\Enums\ProductType::DIGITAL }}";

                $.ajax({
                    url: route('vendor.products.images.reorder', [type, productId]),
                    method: 'POST',
                    data: {
                        images: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        notyf.success(res.message || 'Order updated');
                    },
                    error: function() {
                        notyf.error('Failed to reorder images');
                    }
                });
            }


            function handleVariantManageStockChange(element) {
                const isChecked = $(element).is(':checked');
                const variantQty = $(element).closest('.row').find('.variant-quantity');
                const variantStockStatus = $(element).closest('.row').find('.variant-stock-status');

                if (isChecked) {
                    variantQty.show();
                    variantStockStatus.show();
                } else {
                    variantQty.hide();
                    variantStockStatus.hide();
                }
            }

            enableSortable();
        </script>
    @endpush
@endsection
