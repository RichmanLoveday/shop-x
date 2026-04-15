<div class="accordion" id="accordion-default">
    @foreach ($product->attributeWithValues as $attributeWithValue)
        @php
            $attribute = $attributeWithValue;
            $collapseId = 'collapse-' . $loop->iteration . '-' . uniqid() . '-default';
        @endphp

        <div class="accordion-item">
            <div class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#{{ $collapseId }}" aria-expanded="true">
                    {{ $attribute->name }}
                    <div class="accordion-button-toggle">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-1">
                            <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                    </div>
                </button>
                <span data-product-id="{{ $product->id }}" data-attribute-id="{{ $attribute->id }}"
                    class="delete-btn btn btn-sm btn-danger p-2 fs-2" style="margin-right: 10px;">
                    <i class="ti ti-trash"></i>
                </span>
            </div>
            <div id="{{ $collapseId }}" class="accordion-collapse collapse"
                data-bs-parent="#accordion-default">
                <form action=""></form>
                <form action="" method="POST">
                    @csrf
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label">Name</label>
                                <input type="text" class="form-control" name="attribute_name"
                                    value="{{ $attribute->name }}" id="">
                                <input type="hidden" value="{{ $attribute->id }}" name="attribute_id">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Type</label>
                                <select name="attribute_type" id="type" class="form-control main-type">
                                    @foreach ($attributeTypes as $type)
                                        <option value="{{ $type->value }}" @selected($attribute->type?->value === $type->value)>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="table table-bordered section-table mt-3"
                            style="{{ count($attribute->values) ? '' : 'display: none' }}">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th class="value-header">Value</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($attribute->type?->value === \App\Enums\ProductAttributeType::COLOR->value)
                                    @foreach ($attribute->values as $value)
                                        @php
                                            $pickerId = 'pickr-' . $loop->iteration . '-' . uniqid();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control label-input"
                                                    value="{{ $value->label }}" name="label[]" id=""
                                                    placeholder="">
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div id="{{ $pickerId }}" class="color-preview"
                                                        style="background-color: {{ $value->color }}"></div>
                                                    <input value="{{ $value->color }}" type="hidden"
                                                        data-picker-id="{{ $pickerId }}" class="color-value"
                                                        name="color_value[]" id="">
                                                    <span data-attribute-value-id="{{ $value->id }}"
                                                        data-product-id="{{ $product->id }}"
                                                        data-attribute-id="{{ $attribute->id }}"
                                                        class="review-row-btn ms-2 fs-2 cursor-pointer">
                                                        <i class="ti ti-trash"></i>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($attribute->values as $value)
                                        <tr>
                                            <td colspan="2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <input value="{{ $value->label }}" type="text"
                                                        class="form-control label-input" name="label[]" id=""
                                                        placeholder="Label">
                                                    <span data-attribute-value-id="{{ $value->id }}"
                                                        data-product-id="{{ $product->id }}"
                                                        data-attribute-id="{{ $attribute->id }}"
                                                        class="review-row-btn ms-2 fs-2 cursor-pointer">
                                                        <i class="ti ti-trash"></i>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-2">
                            <button class="btn btn-sm btn-primary add-row-btn" type="button">Add Row</button>
                            <button class="btn btn-sm btn-success save-btn">Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @endforeach
</div>
<button class="btn btn-primary mt-3" id="add-attribute-btn" type="button">Add
    Attribute</button>
