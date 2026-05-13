@props(['cartItems'])
@push('styles')
    <style>
        .cart-thumb-wrapper {
            position: relative;
            width: 90px;
            height: 90px;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .cart-thumb-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* show full image */
            padding: 4px;
            transition: all .3s ease;
        }

        .cart-thumb-wrapper.out-of-stock img {
            filter: brightness(0.82) saturate(0.9);
            transform: scale(1.02);
        }

        /* premium light transparent overlay */
        .stock-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.15) 0%,
                    rgba(255, 255, 255, 0.35) 35%,
                    rgba(255, 255, 255, 0.22) 65%,
                    rgba(255, 255, 255, 0.10) 100%);

            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .stock-overlay span {
            background: rgba(255, 255, 255, 0.75);
            color: #222;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .4px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.4);

            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .stock-badge-danger {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(255, 59, 48, 0.08);
            color: #ff4d4f;
            font-weight: 700;
            font-size: 13px;
        }

        /* smaller cleaner product title */
        .product-name a {
            font-size: 14px !important;
            font-weight: 600;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 240px;
        }
    </style>
@endpush

@forelse ($cartItems as $item)
    @php
        $variantOrProductPrice = $item->variant_or_product_and_stock;
        $price = $variantOrProductPrice['price'];
        $oldPrice = $variantOrProductPrice['old_price'];
        $qty = $item->qty;
        $subTotal = $price * $qty;
        $variantName = $item->variant ? $item->variant->name : '';
        $isOutOfStock = !$variantOrProductPrice['in_stock'];
        $isActive = $variantOrProductPrice['is_active'];
        $text = !$isActive ? 'Inactive' : ($isOutOfStock ? 'Out of Stock' : '');
    @endphp

    <tr class="pt-30">
        <td class="custome-checkbox pl-30">
            <input class="form-check-input cart-checkbox" type="checkbox" name="cart_ids[]"
                id="cartCheckbox{{ $item->id }}" value="{{ $item->id }}">
            <label class="form-check-label" for="cartCheckbox{{ $item->id }}"></label>
        </td>
        <td class="image product-thumbnail pt-40">
            <div class="cart-thumb-wrapper {{ $isOutOfStock ? 'out-of-stock' : '' }}">
                <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}">

                @if ($isOutOfStock || !$isActive)
                    <div class="stock-overlay">
                        <span>{{ $text }}</span>
                    </div>
                @endif
            </div>
        </td>

        <td class="product-des product-name">
            <h6 class="mb-5"><a class="product-name mb-10 text-heading"
                    href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a></h6>
            <div class="product-rate-cover">
                <span class="font-small ml-5 text-muted">{{ $variantName }}</span>
            </div>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width:90%">
                    </div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>
        </td>

        @if ($isOutOfStock)
            <td colspan="3" class="text-center detail-info" data-title="Stock">
                <h4 class="text-brand">
                    Out of Stock
                </h4>
            </td>
        @else
            <td class="price" data-title="Price">
                @if ($oldPrice)
                    <h4 class="text-body">
                        ${{ number_format($price, 2) }}</h4>
                    <h4 class="text-decoration-line-through text-danger" style="font-size: 18px;">
                        ${{ number_format($oldPrice, 2) }}</h4>
                @else
                    <h4 class="text-body">${{ number_format($price, 2) }} </h4>
                @endif
            </td>

            <td class="text-center detail-info" data-title="Stock">
                <div class="detail-extralink mr-15">
                    <div class="detail-qty border radius">
                        <a href="#" class="qty-down">
                            <i class="fi-rs-angle-small-down"></i>
                        </a>

                        <input type="text" data-product-type="{{ $item->product->product_type }}"
                            data-id="{{ $item->id }}" name="quantity" class="qty-val" value="{{ $qty }}"
                            min="1" readonly>

                        <a href="#" class="qty-up">
                            <i class="fi-rs-angle-small-up"></i>
                        </a>
                    </div>
                </div>
            </td>
            <td class="price" data-title="Price">
                <h4 class="text-brand">${{ number_format($subTotal, 2) }} </h4>
            </td>
        @endif

        <td class="action text-center" data-title="Remove"><a href="#" data-id="{{ $item->id }}"
                class="text-body delete-item"><i class="fi-rs-trash"></i></a></td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center py-5">
            <div class="stock-badge-danger">
                Your cart is empty!
            </div>
        </td>
    </tr>
@endforelse
