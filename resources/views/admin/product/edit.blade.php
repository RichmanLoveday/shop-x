@extends('admin.layout.app')
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


                    <div class="card disabled-placeholder {{ $product->attributes->isNotEmpty() ? 'disabled' : '' }}">
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
                                                <input id="manage-stock" class="form-check-input" type="checkbox"
                                                    {{ $product->manage_stock == 'yes' ? 'checked' : '' }}>
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
                                                            {{ old('stock_status') == 'in_stock' || $product->in_stock == 1 ? 'checked' : '' }}>
                                                        <span class="form-check-label">In Stock</span>
                                                    </label>
                                                    <label for="outOfStock" class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="stock_status" value="out_of_stock" id="outOfStock"
                                                            {{ old('stock_status') == 'out_of_stock' || $product->in_stock == 0 ? 'checked' : '' }}>
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
                            <h3 class="card-title">Product Image</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div id="imageUploader" class="image-uploader-box">
                                        <div class="upload-placeholder">
                                            <i class="ti ti-upload"></i>
                                            <p>Drop images here or click to upload</p>
                                        </div>
                                    </div>

                                    <div id="imagePreviewContainer" class="image-preview-container">
                                        @foreach ($product->images ?? [] as $image)
                                            <div class="image-card" data-id="{{ $image->id }}">
                                                <span onclick="removeImage('{{ $image->id }}', this)"
                                                    class="image-remove" data-id="{{ $image->id }}">
                                                    <i class="ti ti-xbox-x fs-1"></i>
                                                </span>
                                                <img src="{{ $image->path }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="product-images" class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Product Attributes</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3 " id="accordion-partial">
                                    @include('admin.product.partials.attributes', [
                                        'product' => $product,
                                        'attributeTypes' => $attributeTypes,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="product-images" class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Product Variants</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="mb-3 " id="accordion-variant-partial">
                                    @include('admin.product.partials.variants', [
                                        'product' => $product,
                                    ])

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 space-y-3">
                    <div class="card">
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
                    </div>

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

                    <div class="card">
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
            $(function() {

                // initialize color picker
                const pickerInstances = {};
                let uniqueCounter = 0;

                function generateUniqueId(prefix = 'picker-') {
                    uniqueCounter++;
                    return `${prefix}${uniqueCounter}-${Date.now()}`;
                }

                function createPicker(pickerId, defaultColor, inputSelector) {
                    if (pickerInstances[pickerId]) {
                        pickerInstances[pickerId].destroyAndRemove();
                    }

                    const picker = Pickr.create({
                        el: `#${pickerId}`,
                        theme: 'classic',
                        default: defaultColor,

                        components: {

                            // Main components
                            preview: true,
                            opacity: true,
                            hue: true,

                            // Input / output Options
                            interaction: {
                                hex: true,
                                rgba: true,
                                hsla: true,
                                hsva: true,
                                cmyk: true,
                                input: true,
                                clear: true,
                                save: true,
                            }
                        }
                    });

                    picker.on('change', (color) => {
                        const selectedColor = color.toHEXA().toString();
                        $(`#${pickerId}`).css('background-color', selectedColor);
                        $(inputSelector).val(selectedColor);
                    });
                }


                function destroyPicker(pickerId) {
                    if (pickerInstances[pickerId]) {
                        pickerInstances[pickerId].destroyAndRemove();
                        delete pickerInstances[pickerId];
                    }
                }


                function initColorPickersInContainer(container) {
                    container.find('.color-preview').each(function() {
                        const $this = $(this);
                        const pickerId = $this.attr('id');
                        const currentColor = $this.css('background-color') || "#000000";
                        console.log(currentColor);
                        createPicker(pickerId, currentColor, `input[data-picker-id="${pickerId}"]`);
                    });
                }

                let count = 0;
                $('#add-attribute-btn').on('click', function() {
                    count++;
                    const collapseId = `collapse-${count}-default`;
                    const headerId = `header${count}`;

                    const accordionItem =
                        `<div class="accordion-item" data-index="${count}">
                            <div class="accordion-header" id="${headerId}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#${collapseId}" aria-controls="${collapseId}" aria-expanded="true">
                                    New Attribute #${count}
                                    <div class="accordion-button-toggle">
                                        <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="icon icon-1">
                                            <path d="M6 9l6 6l6 -6"></path>
                                        </svg>
                                    </div>
                                </button>
                                <span class="delete-btn btn btn-sm btn-danger p-2 fs-2"
                                    style="margin-right: 10px;">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                            <div id="${collapseId}" class="accordion-collapse collapse"
                                data-bs-parent="#accordion-default">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Name</label>
                                                <input type="text" class="form-control" name="attribute_name"
                                                    id="">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="" class="form-label">Type</label>
                                                <select name="attribute_type" id="" class="form-control main-type">
                                                    <option value="text">Text</option>
                                                    <option value="color">Color</option>
                                                </select>
                                            </div>
                                        </div>

                                        <table class="table table-bordered section-table mt-3" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>Label</th>
                                                    <th class="value-header">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody class="section-table-body">

                                            </tbody>
                                        </table>

                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-primary add-row-btn" type="button">Add Row</button>
                                            <button class="btn btn-sm btn-success save-btn">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>`;

                    $('#accordion-default').append(accordionItem);
                });




                $(document).on('click', '.add-row-btn', function() {
                    const accordionBody = $(this).closest('.accordion-body');
                    const type = accordionBody.find('.main-type').val();
                    const table = accordionBody.find('.section-table');
                    const tbody = table.find('tbody');
                    table.show();

                    const pickerId = generateUniqueId();
                    // console.log(pickerId);
                    let rowHtml = '';

                    if (type === 'color') {
                        rowHtml = `
                        <tr>
                             <td>
                            <input type="text" class="form-control label-input"
                                name="label[]" id=""
                                placeholder="">
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div id="${pickerId}" class="color-preview"></div>
                                <input type="hidden" data-picker-id="${pickerId}" class="color-value"
                                    name="color_value[]" id="">
                                <span
                                    class="review-row-btn ms-2 fs-2 cursor-pointer">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                        </td>
                        </tr>
                        `;
                    } else {
                        rowHtml = `
                       <tr>
                         <td colspan="2">
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="text" class="form-control label-input" name="label[]" id="" placeholder="Label">
                                <span class="review-row-btn ms-2 fs-2 cursor-pointer">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                        </td>
                        </tr>
                        `;
                    }

                    tbody.append(rowHtml);

                    // initialize color picker
                    if (type === 'color') {
                        createPicker(pickerId, '#000000', `input[data-picker-id="${pickerId}"]`);
                    }
                });


                // remove attribute values
                $(document).on('click', '.review-row-btn', function() {
                    // alert('hshshs')
                    const $btn = $(this);
                    const $row = $btn.closest('tr');
                    const valueId = $btn.data('attribute-value-id');
                    const attributeId = $btn.data('attribute-id');
                    const productId = $btn.data('product-id');

                    // console.log(valueId, attributeId, productId);

                    const originalHtml = $btn.html();
                    $btn.html('<span class="spinner-border spinner-border-sm"></span>').prop('disabled', true);

                    if (valueId) {
                        $.ajax({
                            url: route('admin.products.attributes.value.destroy', [productId,
                                attributeId, valueId
                            ]),
                            method: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res) {
                                if (res.status) {
                                    $row.fadeOut(300, () => $row.remove());

                                    // $('#accordion-partial').html(res.html);
                                    $('#accordion-variant-partial').html(res.variants);

                                    notyf.success(res.message || 'Value deleted');
                                }
                            },
                            error: function() {
                                notyf.error('Failed to delete value');
                                $btn.html(originalHtml).prop('disabled', false);
                            }
                        });
                    } else {
                        // New row - just remove
                        $row.fadeOut(300, () => {
                            $row.remove();
                            const $table = $btn.closest('.section-table');
                            if ($table.find('tbody tr').length === 0) {
                                $table.hide();
                            }
                        });
                    }
                });


                // change type => rebuild rows and manage picker
                $(document).on("change", ".main-type", function() {
                    const accordionBody = $(this).closest('.accordion-body');
                    const type = $(this).val();
                    const table = accordionBody.find('.section-table');
                    const tbody = table.find('tbody');

                    // collect row values and destroy any existing pickers
                    const labels = [];

                    tbody.find('tr').each(function() {
                        const colorPreview = $(this).find('.color-preview');
                        if (colorPreview.length) {
                            destroyPicker(colorPreview.att('id'));
                        }


                        const labelVal = $(this).find('.label-input').val();
                        labels.push(labelVal || '');
                    });

                    tbody.empty();

                    labels.forEach(label => {
                        const pickerId = generateUniqueId();
                        let rowHtml = "";


                        if (type === 'color') {
                            rowHtml = `
                        <tr>
                             <td>
                            <input type="text" class="form-control label-input"
                                name="label[]" id=""
                                placeholder="" value="${label}">
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div id="${pickerId}" class="color-preview"></div>
                                <input type="hidden" data-picker-id="${pickerId}" class="color-value"
                                    name="color_value[]" id="">
                                <span
                                    class="review-row-btn ms-2 fs-2 cursor-pointer">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                        </td>
                        </tr>
                        `;
                        } else {
                            rowHtml = `
                       <tr>
                         <td colspan="2">
                            <div class="d-flex justify-content-between align-items-center">
                                <input type="text" class="form-control label-input" name="label[]" id="" placeholder="Label" value="${label}">
                                <span class="review-row-btn ms-2 fs-2 cursor-pointer">
                                    <i class="ti ti-trash"></i>
                                </span>
                            </div>
                        </td>
                        </tr>
                        `;
                        }

                        tbody.append(rowHtml);

                        // initialize color picker
                        if (type === 'color') {
                            createPicker(pickerId, '#000000', `input[data-picker-id="${pickerId}"]`);
                        }
                    })


                    // hide table when label is empty
                    if (labels.length > 0) {
                        table.show();
                    } else {
                        table.hide();
                    }
                });


                // $(document).on('click', '.delete-btn', function() {
                //     const accordionItem = $(this).closest('.accordion-item');
                //     accordionItem.find('.color-preview').each(function() {
                //         destroyPicker($(this).attr('id'));
                //     });


                //     $.ajax({
                //         url: '',
                //         method: "DELETE",
                //         data: {},
                //         before
                //         success: function(res) {},
                //         error: function(res) {},
                //     })

                //     accordionItem.remove();
                // });


                // delete attribute from DOM
                $(document).on('click', '.delete-btn', function() {
                    const $btn = $(this);
                    const $accordionItem = $btn.closest('.accordion-item');
                    const attributeId = $btn.data('attribute-id');
                    const productId = $btn.data('product-id');

                    if (!attributeId || !productId) {
                        Swal.fire('Error', 'Attribute ID not found', 'error');
                        return;
                    }

                    // SweetAlert Confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this! All values under this attribute will also be deleted.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // Show spinner on button
                            const originalHtml = $btn.html();
                            $btn.html(
                                    '<span class="spinner-border spinner-border-sm" role="status"></span>'
                                )
                                .prop('disabled', true);

                            $.ajax({
                                url: route('admin.products.attributes.destroy', [productId,
                                    attributeId
                                ]),
                                method: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(res) {
                                    if (res.status === true) {
                                        // Destroy color pickers before removing
                                        $accordionItem.find('.color-preview').each(
                                            function() {
                                                destroyPicker($(this).attr('id'));
                                            });

                                        // Remove with animation
                                        $accordionItem.fadeOut(400, function() {
                                            $(this).remove();

                                            // $('#accordion-partial').html(res.html);
                                            $('#accordion-variant-partial').html(res
                                                .variants);

                                            // add product pricing filled
                                            if (res.attributes.length === 0) {
                                                $('.disabled-placeholder').removeClass(
                                                    'disabled')
                                            }


                                            // Optional: Show empty state if no attributes left
                                            if ($(
                                                    '#accordion-default .accordion-item'
                                                )
                                                .length === 0) {
                                                $('#accordion-default').html(
                                                    '<p class="text-muted p-4 text-center">No attributes added yet.</p>'
                                                );
                                            }
                                        });

                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: res.message ||
                                                'Attribute has been deleted successfully.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    console.error(xhr);
                                    Swal.fire({
                                        title: 'Error!',
                                        text: xhr.responseJSON?.message ||
                                            'Failed to delete attribute',
                                        icon: 'error'
                                    });

                                    // Restore button
                                    $btn.html(originalHtml).prop('disabled', false);
                                }
                            });
                        }
                    });
                });


                // save attribute to database
                $(document).on('click', '.save-btn', function(e) {
                    e.preventDefault();
                    const form = $(this).closest('form');
                    const data = form.serialize();

                    // console.log(data);
                    $.ajax({
                        url: route('admin.products.attributes.store', {{ $product->id }}),
                        method: "POST",
                        data: data,
                        success: function(res) {

                            if (res.status) {
                                $('#accordion-partial').html(res.html);
                                $('#accordion-variant-partial').html(res.variants);

                                // add product pricing filled
                                if (res.attributes.length > 0) {
                                    $('.disabled-placeholder').addClass('disabled')
                                }

                                // Re-initialize color pickers if needed
                                initColorPickersInContainer($('#accordion-default'));
                                notyf.success(res.message);
                            }
                        },
                        error: function(res) {
                            // console.log(res);

                            if (res.status === 422) {
                                const errors = res.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    notyf.error(value[0]);
                                });
                            }

                            if (res.status === 500) {
                                notyf.error(res.responseJSON.message ||
                                    'Server error while saving attribute');
                            }
                        }
                    });
                });

                // initialize existing color pickers on page load
                $(document).ready(function() {
                    initColorPickersInContainer($('#accordion-default'));
                });
            });
        </script>
        <script>
            if (Dropzone.instances.length) {
                Dropzone.instances.forEach(dz => dz.destroy());
            }

            $(document).ready(function() {
                $('#select_store').select2({
                    placeholder: 'Search for stores...',
                    minimumInputLength: 2,
                    ajax: {
                        url: route('admin.stores.search'),
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                name: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.stores.map(function(store) {
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


                $('#select_store').on('select2:select', function(e) {
                    let data = e.params.data;

                    // Create a real option if it doesn't exist
                    let option = new Option(data.text, data.id, true, true);
                    $(this).append(option).trigger('change');
                });


                // $('#select_brand').select2({
                //     placeholder: 'Search for brands...',
                //     minimumInputLength: 2, // avoid unnecessary API calls
                //     ajax: {
                //         url: route('admin.brands.search'),
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
                        url: route('admin.tags.search'),
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
                    console.log(el);
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


                // code block to handle date pickers with litepicker
                if (window.Litepicker) {
                    // FROM DATE PICKER
                    fromPicker = new Litepicker({
                        element: document.getElementById('from_date'),
                        minDate: new Date(), // block past dates
                        buttonText: {
                            previousMonth: `<i class="ti ti-chevron-left fs-2"></i>`,
                            nextMonth: `<i class="ti ti-chevron-right fs-2"></i>`,
                        },

                        setup: (picker) => {
                            picker.on('selected', (date) => {
                                // Enable End Date
                                $('#end_date').prop('disabled', false);

                                // Set minimum selectable date for End Date
                                toPicker.setOptions({
                                    minDate: date.clone().add(1,
                                        'day') // must be greater than start date
                                });
                            });

                            picker.on('clear', () => {
                                // Clear and disable End Date if From Date is cleared
                                $('#end_date').val('').prop('disabled', true);
                                toPicker.clearSelection();
                            });
                        }
                    });

                    // TO DATE PICKER
                    toPicker = new Litepicker({
                        element: document.getElementById('end_date'),
                        buttonText: {
                            previousMonth: `<i class="ti ti-chevron-left fs-2"></i>`,
                            nextMonth: `<i class="ti ti-chevron-right fs-2"></i>`,
                        },
                        minDate: null // will be set dynamically

                    });

                    // Disable End Date initially
                    // $('#end_date').prop('disabled', true);
                }

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
                    let url = route('admin.products.update', {{ $product->id }});

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                notyf.success(response.message || 'Product updated successfully');
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


                Dropzone.autoDiscover = false;

                let myDropzone = new Dropzone("#imageUploader", {
                    url: route('admin.products.upload-image', {{ $product->id }}),
                    paramName: "image",
                    maxFilesize: 10,
                    acceptedFiles: "image/*",
                    previewsContainer: false,

                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    init: function() {

                        this.on("addedfile", function(file) {

                            let preview = `
                            <div class="image-card uploading">
                                <div class="image-loader">
                                    <span></span><span></span><span></span>
                                </div>
                                <div class="uploading-text">Uploading...</div>
                            </div>
                        `;

                            file._previewEl = $(preview).appendTo('#imagePreviewContainer');
                        });

                        this.on("success", function(file, response) {

                            const productImage = response.productImage;

                            let html = `
                                <div class="image-card" data-id="${productImage.id}">
                                    <span class="image-remove" data-id="${productImage.id}">
                                        <i class="ti ti-xbox-x fs-1"></i>
                                    </span>
                                    <img src="${productImage.path}" />
                                </div>
                            `;

                            file._previewEl.replaceWith(html);

                            enableSortable();
                        });

                        this.on("error", function(file) {
                            console.log(file)
                            const errors = JSON.parse(file.xhr.response).errors;
                            console.log(errors);
                            if (file.xhr.status == 422) {
                                $.each(errors, function(key, value) {
                                    notyf.error(errors[key][0]);
                                });
                            }

                            if (file.xhr.status == 500) {
                                notyf.error('Server error while uploading image');
                            }

                            file._previewEl.remove();
                        });
                    }
                });
            });


            // remove image
            function removeImage(imageId, element) {
                $.ajax({
                    url: route('admin.products.images.destroy', imageId),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        $(element).closest('.image-card').remove();
                    },
                    error: function() {}
                });
            }

            // delegate click handler for image removal
            $(document).on('click', '.image-remove', function() {
                const imageId = $(this).data('id');
                removeImage(imageId, this);
            });


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

                $.ajax({
                    url: route('admin.products.images.reorder', productId),
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


            function submitVariantForm(e) {
                e.preventDefault();
                const $form = $(this);
                const $btn = $form.find('.save-variant-btn');
                const data = $form.serialize();

                $.ajax({
                    url: route('admin.products.variant', [{{ $product->id }}]),
                    type: 'POST',
                    data: data,
                    beforeSend: function() { // ← Fixed: beforeSend (not beforeSending)
                        $btn.prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
                    },
                    success: function(res) {
                        console.log(res);

                        if (res.status) {
                            notyf.success(res.message);
                            $btn.prop('disabled', false)
                                .html('Save');
                        }
                    },
                    error: function(res) {
                        if (res.status === 422) {
                            const errors = res.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                notyf.error(value[0]);
                            });
                        }

                        if (res.status === 500) {
                            notyf.error(res.responseJSON.message ||
                                'Server error while saving attribute');
                        }

                        $btn.prop('disabled', false)
                            .html('Save');
                    }
                });
            }
            $('#variant-form').on('submit', submitVariantForm);


            enableSortable();
        </script>
    @endpush
@endsection
