@extends('admin.layout.app')
@push('styles')
    <style>
        /* Container */
        .spotify-light-tree {
            background: var(--tblr-bg-surface);
            padding: 15px;
        }

        /* List */
        .spotify-light-tree .dd-list {
            list-style: none;
            padding-left: 20px;
        }

        /* Item */
        .spotify-light-tree .dd-item {
            margin: 10px 0;
        }

        /* Main row */
        .category-item {
            background: var(--tblr-bg-surface);
            border-bottom: 1px solid var(--tblr-border-color);
            padding: 16px 20px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            cursor: grab;
            transition: background 0.2s ease;
        }


        /* Hover */
        .category-item:hover {
            background: var(--tblr-bg-surface-secondary);
        }

        /* Left side */
        .category-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Folder icon */
        .folder-icon {
            font-size: 18px;
            color: var(--tblr-muted);
        }

        /* Category text */
        .category-left span {
            font-size: 15px;
            color: var(--tblr-body-color);
        }

        /* Right side */
        .category-right {
            display: flex;
            align-items: center;
        }

        /* Status dot */
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        /* Active */
        .status-dot.active {
            background: var(--tblr-success);
        }

        /* Inactive */
        .status-dot.inactive {
            background: var(--tblr-danger);
        }

        /* Nested */
        .spotify-light-tree .dd-list .dd-list {
            border-left: 2px solid var(--tblr-border-color);
            margin-left: 15px;
            padding-left: 15px;
        }

        /* Drag state */
        .dd-item.dd-dragel .category-item {
            opacity: 0.6;
        }

        .dd-list .dd-list::before {
            content: "";
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 1px;
            background: var(--tblr-border-color);
        }


        /* Loader overlay (light version) */
        .spotify-loader-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--tblr-body-color);
            backdrop-filter: blur(4px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Spotify loader */
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
    </style>
@endpush
@section('contents')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Categories</span>
                        <button class="btn btn-primary">New</button>
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
                        <span>Create Category</span>
                    </div>
                    <div class="card-body">
                        <form action="" id="category-form">
                            <div class="mb-4">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required id="name">
                            </div>

                            <div class="mb-4">
                                <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" required id="slug">
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
                                <button class="btn btn-danger" type="button" id="bnt-save">Delete</button>
                                <button class="btn btn-secondary" type="submit" id="bnt-cancel">Cancel</button>
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
            // const notyf = new Notyf();
            $('#category-form').submit(function(e) {
                e.preventDefault();
                console.log(e);
                const method = "POST";
                const url = route('admin.categories.store');
                const data = {
                    name: $('#name').val(),
                    slug: $('#slug').val(),
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
                        }

                        if (!response.status) {
                            notyf.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);
                        $.each(errors, function(key, value) {
                            console.log(key, value);
                            notyf.error(value[0] || 'An error occurred');
                        });
                    }
                });



                function clearForm() {
                    $('#name').val('');
                    $('#slug').val('');
                    $('#parent_id').val('');
                    $('#is_active').prop('checked', false);
                    loadParentDropdown(null, null);
                }
            });


            // load parent dropdown
            function loadParentDropdown(selectedId, excludedId) {
                $('#tree-loading').removeClass('d-none');

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

                            if (cat.children_nested && cat.children_nested.length) {
                                addOptions(cat.children_nested, prefix + "--", depth + 1);
                            }
                        });

                    })(categories, '', 0);


                    // change html text content
                    $('#parent_id').html(options);

                    $('#category-tree').html(buildTree(categories));

                    $('#category-tree').nestable({
                        maxDepth: 3
                    });

                    $('#tree-loading').addClass('d-none');
                });
            };

            loadParentDropdown(null, null);



            function buildTree(categories) {
                let html = '<ol class="dd-list">';

                categories.forEach(cat => {
                    html += `
            <li class="dd-item" data-id="${cat.id}">
                <div class="dd-handle category-item">

                    <div class="category-left">
                        <i class="ti ti-folder folder-icon"></i>
                        <span>${cat.name}</span>
                    </div>

                    <div class="category-right">
                        <span class="status-dot ${cat.is_active ? 'active' : 'inactive'}"></span>
                    </div>

                </div>
        `;

                    if (cat.children_nested && cat.children_nested.length) {
                        html += buildTree(cat.children_nested);
                    }

                    html += `</li>`;
                });

                html += '</ol>';

                return html;
            }


            $('#category-tree').on('change', function() {
                let structure = $(this).nestable('serialize');

                console.log(structure);

                $.ajax({
                    url: route('admin.categories.reorder'),
                    method: 'POST',
                    data: {
                        tree: structure,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        });
    </script>
@endpush
