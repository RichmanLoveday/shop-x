<div class="accordion" id="accordion-variants">
    @foreach ($product->variants as $variant)
        <div class="accordion-item">
            <div class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#variant-{{ $variant->id }}" aria-expanded="true">
                    {{ $variant->name }}

                    @if ($variant->is_default)
                        <span class="badge badge-sm bg-primary text-white text-end">default</span>
                    @endif

                    @if ($variant->is_active)
                        <span class="badge badge-sm bg-success text-white text-end">active</span>
                    @else
                        <span class="badge badge-sm bg-danger text-white text-end">in-active</span>
                    @endif
                    <div class="accordion-button-toggle">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-1">
                            <path d="M6 9l6 6l6 -6"></path>
                        </svg>
                    </div>
                </button>
            </div>
            <div id="variant-{{ $variant->id }}" class="accordion-collapse collapse"
                data-bs-parent="#accordion-variants">
                {{-- <form action=""></form> --}}
                <form action="" method="POST" id="variant-form" class="variant-form">
                    @csrf
                    <input type="hidden" value="{{ $variant->id }}" name="variant_id">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="" class="form-label">Sku</label>
                                <input disabled type="text" class="form-control" name="variant_sku"
                                    value="{{ $variant->sku }}" id="">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Price</label>
                                <input type="text" class="form-control" name="variant_price"
                                    value="{{ $variant->price }}" id="">
                                <input type="hidden" value="" name="attribute_id">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Special Price</label>
                                <input type="text" class="form-control" name="variant_special_price"
                                    value="{{ $variant->special_price }}" id="">
                            </div>


                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label for="variant-manage-stock" class="form-check ">
                                        <input id="variant-manage-stock" name="variant_manage_stock"
                                            onchange="handleVariantManageStockChange(this)" class="form-check-input "
                                            type="checkbox" {{ $variant->manage_stock ? 'checked' : '' }}>
                                        <span class="form-check-label">Manage Stock</span>
                                    </label>
                                </div>

                                <div class="col-md-12 mb-2 variant-quantity"
                                    style="display: {{ $variant->manage_stock ? 'block' : 'none' }}"
                                    id="quantity-field">
                                    <label class="form-label">Quantity</label>
                                    <input type="text" name="variant_quantity" value="{{ $variant->qty }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-12 mb-2 variant-stock-status"
                                    style="display: {{ $variant->manage_stock ? 'block' : 'none' }}">
                                    <div class="card">
                                        <div class="card-body space-y-2 ">
                                            <label for="">Stock Status</label>
                                            <div class="d-flex gap-2">
                                                <label for="VariantInStock" class="form-check">
                                                    <input type="radio" class="form-check-input"
                                                        name="variant_stock_status" value="in_stock" id="VariantInStock"
                                                        {{ $variant->stock_status == 1 ? 'checked' : '' }}>
                                                    <span class="form-check-label">In Stock</span>
                                                </label>
                                                <label for="VariantOutOfStock" class="form-check">
                                                    <input type="radio" class="form-check-input"
                                                        name="variant_stock_status" value="out_of_stock"
                                                        id="VariantOutOfStock"
                                                        {{ $variant->stock_status == 0 ? 'checked' : '' }}>
                                                    <span class="form-check-label">Out of Stock</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12 mb-2">
                                <div class="d-flex gap-2">
                                    <label class="form-check form-switch form-switch-3">
                                        <input class="form-check-input" id="status" type="checkbox"
                                            name="variant_is_active" {{ $variant->is_active ? 'checked' : '' }}>
                                        <span class="form-check-label">Is Active</span>
                                    </label>

                                    <label class="form-check form-switch form-switch-3">
                                        <input class="form-check-input" id="status" type="checkbox"
                                            name="variant_is_default" {{ $variant->is_default ? 'checked' : '' }}>
                                        <span class="form-check-label">Is Default</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-success save-variant-btn"
                                onsubmit="submitVariantForm(this)">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
