@extends('admin.layout.app')
@section('contents')
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
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" required>
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>


                            </div>

                            {{-- Short Description --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" id="short-description" cols="50" rows="10">{{ old('short_description') }}</textarea>
                                    <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Content</label>
                                    <textarea name="long_description" class="form-control" id="long-description" cols="50" rows="10" required>{{ old('long_description') }}</textarea>
                                    <x-input-error :messages="$errors->get('long_description')" class="mt-2" />
                                </div>
                            </div>


                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="thumbnail" class="form-label required">Thumbnail</label>
                                    <x-input-image imageUpload="thumbnail" id="preview-image" name="thumbnail"
                                        previewImage="preview-thumbnail" :image="auth()->user()->avatar" class="thumbnail" />

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
                                        <input type="text" name="sku" value="{{ old('sku') }}"
                                            class="form-control">
                                        <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                    </div>
                                </div>


                                {{-- Price --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" name="price" value="{{ old('price') }}"
                                            class="form-control">
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Special Price</label>
                                        <input type="text" name="special_price" value="{{ old('special_price') }}"
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
                                                value="{{ old('from_date') }}" name="from_date">
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
                                                value="{{ old('end_date') }}" name="end_date">
                                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 ">
                                            <label for="manage-stock" class="form-check">
                                                <input id="manage-stock" class="form-check-input" type="checkbox" name="manage_stock">
                                                <span class="form-check-label">Manage Stock</span>
                                            </label>
                                            <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                                        </div>
                                    </div>


                                    <div class="col-md-6" style="display: none" id="quantity-field">
                                        <div class="mb-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="text" name="quantity" value="{{ old('quantity') }}"
                                                class="form-control">
                                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row" style="display: none" id="stock-status-field">
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
                                                            {{ old('stock_status') == 'in_stock' ? 'checked' : '' }}>
                                                        <span class="form-check-label">In Stock</span>
                                                    </label>
                                                    <label for="outOfStock" class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            name="stock_status" value="out_of_stock" id="outOfStock"
                                                            {{ old('stock_status') == 'out_of_stock' ? 'checked' : '' }}>
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
                                                        name="categories[]" value="{{ $category->id }}">
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
                                                                        name="categories[]" value="{{ $child->id }}">
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
                                                                                        value="{{ $grandChild->id }}">
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
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                            name="is_featured">
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
                                        <input id="hot" class="form-check-input" type="checkbox" name="is_hot">
                                        <span class="form-check-label">Hot</span>
                                    </label>
                                    <label for="new" class="form-check">
                                        <input id="new" class="form-check-input" type="checkbox" name="is_new">
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
                                        <option value="{{ $item->value }}">{{ $item->label() }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="w-100 text-center">
                                <button class="btn btn-primary w-100" type="submit">Create Product</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    @push('scripts')
        <script>
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
                    $('#end_date').prop('disabled', true);
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
                    let type = "{{ request()->type }}"
                    let formData = new FormData(form[0]);
                    let url = route('admin.products.store', type);

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status) {
                                const product = response.product;
                                const redirectUrl = type === 'physical' ? route(
                                    'admin.products.edit', product.id) : route(
                                    'admin.product.digital.edit', product.id);

                                // redirect to edit page of the created product
                                window.location.href = redirectUrl;
                            }
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                // console.log(errors);

                                // Display new errors
                                $.each(errors, function(key, value) {
                                    notyf.error(errors[key][0]);
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
