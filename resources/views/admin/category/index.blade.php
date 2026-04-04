@extends('admin.layout.app')
@push('styles')
    <style>
        /* ===============================
                                                                                                                                                                                   CONTAINER
                                                                                                                                                                                ================================= */
        .spotify-light-tree {
            background: var(--tblr-bg-surface);
            padding: 12px;
        }

        /* ===============================
                                                                                                                                                                                   LIST STRUCTURE
                                                                                                                                                                                ================================= */
        .spotify-light-tree .dd-list {
            list-style: none;
            margin: 0;
            padding-left: 20px;
            position: relative;
        }

        /* vertical connector line */
        .spotify-light-tree .dd-list .dd-list {
            margin-left: 15px;
            padding-left: 15px;
            border-left: 1px solid var(--tblr-border-color);
        }

        /* ===============================
                                                                                                                                                                                   ITEM WRAPPER
                                                                                                                                                                                ================================= */
        .spotify-light-tree .dd-item {
            margin: 8px 0;
        }

        /* ===============================
                                                                                                                                                                                   MAIN ROW (Spotify style)
                                                                                                                                                                                ================================= */
        .dd-item-row {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 14px 18px;

            background: var(--tblr-bg-surface);
            border-bottom: 1px solid var(--tblr-border-color);

            transition: all 0.2s ease;
        }

        /* hover effect */
        .dd-item-row:hover {
            background: var(--tblr-bg-surface-secondary);
        }

        /* ===============================
                                                                                                                                                                                   DRAG HANDLE
                                                                                                                                                                                ================================= */
        .drag-handle {
            cursor: grab;
            color: var(--tblr-muted);
            display: flex;
            align-items: center;
            padding: 4px;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        /* ===============================
                                                                                                                                                                                   FOLDER ICON
                                                                                                                                                                                ================================= */
        .folder-icon {
            font-size: 18px;
            color: var(--tblr-muted);
        }

        /* ===============================
                                                                                                                                                                                   CATEGORY NAME (CLICKABLE)
                                                                                                                                                                                ================================= */
        .cat-label {
            flex: 1;
            cursor: pointer;
            font-size: 15px;
            color: var(--tblr-body-color);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        /* hover */
        .cat-label:hover {
            color: var(--tblr-primary);
        }

        /* selected state */
        .cat-label.active {
            color: var(--tblr-primary);
            font-weight: 600;
        }

        /* ===============================
                                                                                                                                                                                   RIGHT SIDE (STATUS)
                                                                                                                                                                                ================================= */
        .category-right {
            display: flex;
            align-items: center;
        }

        /* status dot */
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* active */
        .status-dot.active {
            background: var(--tblr-success);
        }

        /* inactive */
        .status-dot.inactive {
            background: var(--tblr-danger);
        }

        /* ===============================
                                                                                                                                                                                   DRAGGING STATE
                                                                                                                                                                                ================================= */
        .dd-item.dd-dragel .dd-item-row {
            opacity: 0.6;
            background: var(--tblr-bg-surface-secondary);
        }

        /* ===============================
                                                                                                                                                                                   LOADER OVERLAY (Spotify vibe)
                                                                                                                                                                                ================================= */
        .spotify-loader-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            background: rgba(0, 0, 0, 0.15);
            /* works for light & dark */
            backdrop-filter: blur(4px);

            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        /* loader bars */
        .spotify-loader {
            display: flex;
            gap: 5px;
        }

        .spotify-loader span {
            width: 5px;
            height: 25px;
            background: #1db954;
            border-radius: 10px;
            animation: bounce 1s infinite ease-in-out;
        }

        .spotify-loader span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .spotify-loader span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: scaleY(0.4);
                opacity: 0.5;
            }

            50% {
                transform: scaleY(1.2);
                opacity: 1;
            }
        }

        /* ===============================
                                                                                                                                                                                   DARK MODE IMPROVEMENTS
                                                                                                                                                                                ================================= */
        [data-bs-theme="dark"] .spotify-light-tree {
            background: var(--tblr-bg-surface);
        }

        [data-bs-theme="dark"] .dd-item-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* ===============================
                                                                                                                                                                                   SMOOTH TRANSITIONS
                                                                                                                                                                                ================================= */
        .dd-item-row,
        .cat-label,
        .status-dot {
            transition: all 0.2s ease;
        }
    </style>
@endpush
@section('contents')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Categories</span>
                        <button id="btn-new" class="btn btn-primary">New</button>
                    </div>

                    <div class="card-body position-relative">
                        <div id="category-tree" class="dd spotify-light-tree"></div>

                        <div id="tree-loading" class="spotify-loader-overlay d-none">
                            <div class="spotify-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span id="category-title">Create Category</span>
                    </div>
                    <div class="card-body">
                        <form action="" id="category-form">
                            <input type="hidden" id="category-id">
                            <div class="mb-4">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required id="name">
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input disabled type="text" name="slug" class="form-control" required id="slug">
                            </div>

                            <div class="mb-4">
                                <label for="parent_id" class="form-label">Parent Category <span
                                        class="text-danger">*</span></label>
                                <select class=" form-select form-control" name="parent_id" id="parent_id"></select>
                            </div>

                            <div class="mb-4">
                                <label class="form-check form-switch form-switch-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                                    <span class="form-check-label">Active</span>
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" type="submit" id="bnt-save">Save</button>
                                <button class="btn btn-danger d-none" type="button" id="btn-delete">Delete</button>
                                <button class="btn btn-secondary" type="submit" id="btn-cancel">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            function fillForm(cat) {
                $('#category-title').text('Edit Category');
                $('#name').val(cat.name);
                $('#slug').val(cat.slug);
                $('#is_active').prop('checked', cat.is_active);
                loadParentDropdown(cat.parent_id, cat.id);
                $('#category-id').val(cat.id);
                $('#btn-delete').removeClass('d-none');
            }


            function clearForm() {
                $('#category-title').text('Create Category');
                $('#name').val('');
                $('#slug').val('');
                $('#parent_id').val('');
                $('#is_active').prop('checked', false);
                loadParentDropdown(null, null);
                $('#btn-delete').addClass('d-none');
                $('#category-id').val('');
            }


            // const notyf = new Notyf();
            $('#category-form').submit(function(e) {
                e.preventDefault();
                console.log(e);
                const id = $('#category-id').val();
                // console.log(id);
                const method = id ? "PUT" : "POST";
                const url = id ? route('admin.category.update', id) : route('admin.categories.store');
                const data = {
                    name: $('#name').val(),
                    // slug: $('#slug').val(),
                    parent_id: $('#parent_id').val(),
                    is_active: $('#is_active').is(':checked') ? 1 : 0,
                    _token: "{{ csrf_token() }}",
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        clearForm();

                        if (response.status) {
                            notyf.success(response.message);
                            loadTree();
                        }

                        if (!response.status) {
                            notyf.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON?.errors;

                            if (errors) {
                                $.each(errors, function(key, value) {
                                    notyf.error(value[0]); // show first error per field
                                });
                            } else {
                                notyf.error('Validation failed');
                            }
                        } else if (xhr.status === 500) {
                            let message = xhr.responseJSON?.message || 'Server error occurred';
                            notyf.error(message);
                        } else {
                            let message = xhr.responseJSON?.message ||
                                'Unexpected error occurred';
                            notyf.error(message);
                        }

                        // optional debug (remove in production)
                        console.log('Status:', xhr.status);
                        console.log('Response:', xhr.responseText);
                    }
                });
            });






            $(document).on('click', '.cat-label', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let id = $(this).data('id');

                console.log('Clicked:', id);

                $.get(route('admin.category.show', id), function(res) {
                    console.log(res);
                    fillForm(res.category);
                });
            });


            // load parent dropdown
            function loadParentDropdown(selectedId, excludedId) {
                $.get(route('admin.categories.nested'), function(data) {
                    // console.log(data);
                    const categories = data.categories;
                    console.log(categories);
                    let options = `<option value="">None (Root)</option>`;

                    (function addOptions(categories, prefix, depth) {
                        categories.forEach(function(cat) {
                            if (cat.id == excludedId) return;
                            options +=
                                `<option value="${cat.id}" ${selectedId == cat.id ? 'selected' : ''}>${prefix}${cat.name}</option>`;

                            if (cat.children && cat.children.length) {
                                addOptions(cat.children, prefix + "--", depth + 1);
                            }
                        });

                    })(categories, '', 0);


                    // change html text content
                    $('#parent_id').html(options);
                });
            };


            function loadTree() {
                $('#tree-loading').removeClass('d-none');

                $.get(route('admin.categories.nested'), function(res) {
                    let html = `<div class="dd" id="nestable-tree">${buildTree(res.categories)}</div>`;
                    $('#category-tree').html(html);

                    $('#nestable-tree').nestable({
                        maxDepth: 3
                    }).off('change').on('change', function(e) {
                        if (!$(e.target).hasClass('no-drag')) {
                            console.log(e)
                            updateOrder();
                        }
                    });
                    $('#tree-loading').addClass('d-none'); // ✅ hide loader
                });
            }



            function buildTree(categories) {
                let html = '<ol class="dd-list">';

                categories.forEach(cat => {
                    html += `
                        <li class="dd-item" data-id="${cat.id}">
                            <div class="dd-item-row">

                                <!-- Drag -->
                                <div class="dd-handle drag-handle">
                                    <i class="ti ti-grip-horizontal"></i>
                                </div>

                                <!-- Folder -->
                                <i class="ti ti-folder folder-icon"></i>

                                <!-- Click -->
                                <div class="cat-label category-name" data-id="${cat.id}">
                                    ${cat.name}
                                </div>

                                <!-- Status -->
                                <div class="category-right">
                                    <span class="status-dot ${cat.is_active ? 'active' : 'inactive'}"></span>
                                </div>

                            </div>
                        `;

                    // ✅ children INSIDE li
                    if (cat.children && cat.children.length) {
                        html += buildTree(cat.children);
                    }

                    html += `</li>`;
                });

                html += '</ol>';

                return html;
            }





            function updateOrder() {
                let structure = $('#nestable-tree').nestable('serialize');

                $.ajax({
                    url: route('admin.categories.reorder'),
                    method: 'POST',
                    data: {
                        tree: structure,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            notyf.success(response.message);
                            loadTree();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 500) {
                            let message = xhr.responseJSON?.message || 'Server error occurred';
                            notyf.error(message);
                        }
                    }
                });
            }



            // load idividual category
            $(document).on('click', '.cat-label', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let id = $(this).data('id');

                $.get(route('admin.category.show', id), function(res) {
                    fillForm(res.category);
                });
            });


            // delete category
            $('#btn-delete').on('click', function(e) {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $('#category-id').val();
                        console.log(id);

                        $.ajax({
                            url: route('admin.category.delete', id),
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (!res.status) {
                                    Swal.fire(
                                        'Error!',
                                        res.message,
                                        'error'
                                    );
                                    return;
                                }

                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                ).then(() => {
                                    clearForm();
                                    loadTree();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 500) {
                                    let message = xhr.responseJSON?.message ||
                                        'Server error occurred';

                                    Swal.fire(
                                        'Error!',
                                        message,
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });


            // clear form when you click on btn new
            $('#btn-new').on('click', function() {
                clearForm();
            });

            $('#btn-cancel').on('click', function() {
                clearForm();
            });


            //initial load
            loadTree();
            clearForm();
            loadParentDropdown(null, null);
        });
    </script>
@endpush
