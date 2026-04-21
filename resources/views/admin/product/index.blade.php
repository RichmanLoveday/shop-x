@extends('admin.layout.app')
@section('contents')
    <div class="container-xl">
        <div class="row row-deck row-cards space-y-4">
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span
                                            class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path
                                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                <path d="M12 3v3m0 12v3" />
                                            </svg></span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">132 Sales</div>
                                        <div class="text-secondary">12 waiting payments</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span
                                            class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/shopping-cart -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M17 17h-11v-14h-2" />
                                                <path d="M6 5l14 1l-1 7h-13" />
                                            </svg></span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">78 Orders</div>
                                        <div class="text-secondary">32 shipped</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span
                                            class="bg-x text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                                <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                                            </svg></span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">623 Shares</div>
                                        <div class="text-secondary">16 today</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span
                                            class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-facebook -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path
                                                    d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                                            </svg></span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">132 Likes</div>
                                        <div class="text-secondary">21 today</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Products </h3>
                        <div class="card-actions">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Create Product
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.products.create', App\Enums\ProductType::PHYSICAL) }}">
                                            Physical
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.products.create', App\Enums\ProductType::DIGITAL) }}">
                                            Digital
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Stock Status</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Store</th>
                                        <th>Created At</th>
                                        <th class="w-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                        @php
                                            $stockStatusBg = 'bg-danger';
                                            $stockStatusText = 'out_of_stock';
                                            $digitalProductType = \App\Enums\ProductType::DIGITAL;
                                            $physicalProductType = \App\Enums\ProductType::PHYSICAL;

                                            if ($product->primaryVariant) {
                                                if ($product->primaryVariant?->stock_status) {
                                                    $stockStatusBg = 'bg-success';
                                                    $stockStatusText = 'in_stock';
                                                }
                                            } else {
                                                if ($product->stock_status) {
                                                    $stockStatusBg = 'bg-success';
                                                    $stockStatusText = 'in_stock';
                                                }
                                            }

                                        @endphp

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $product->thumbnail }}" class="w-8 h-8" alt="">
                                            </td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->name }}
                                                    </a>
                                                </div>
                                                <small
                                                    class="text-muted text-sm text-capitalize">{{ $product->product_type?->label() }}</small>
                                            </td>
                                            <td>
                                                <div>
                                                    @if ($product->primaryVariant)
                                                        @if ($product->primaryVariant->special_price > 0)
                                                            <div>
                                                                {{ $product->primaryVariant->special_price }}
                                                            </div>
                                                            <div class="text-danger text-sm text-decoration-line-through">
                                                                {{ $product->primaryVariant->price }}
                                                            </div>
                                                        @else
                                                            {{ $product->primaryVariant->price }}
                                                        @endif
                                                    @else
                                                        @if ($product->special_price > 0)
                                                            <div>
                                                                {{ $product->special_price }}
                                                            </div>
                                                            <div class="text-danger text-sm text-decoration-line-through">
                                                                {{ $product->price }}
                                                            </div>
                                                        @else
                                                            {{ $product->price }}
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <small
                                                    class="badge badge-sm text-white {{ $stockStatusBg }}">{{ $stockStatusText }}</small>
                                            </td>
                                            <td>
                                                @if ($product->primaryVariant)
                                                    @if ($product->primaryVariant?->manage_stock == 'yes')
                                                        {{ $product->primaryVariant->qty }}
                                                    @else
                                                        ∞
                                                    @endif
                                                @else
                                                    @if ($product->manage_stock == 'yes')
                                                        {{ $product->qty }}
                                                    @else
                                                        ∞
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-sm text-white {{ $product->status?->color() }}">{{ $product->status?->label() }}
                                                </span>
                                            </td>
                                            <td>{{ $product->store->name }}</td>
                                            <td>{{ date('Y-m-d', strtotime($product->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex w-100 justify-content-between space-x-1">
                                                    <a class=" text-decoration-none"
                                                        href="{{ $product->product_type === $physicalProductType ? route('admin.products.edit', $product->id) : route('admin.product.digital.edit', $product->id) }}">
                                                        <i class="ti ti-edit fs-1"></i>
                                                    </a>

                                                    <a class="delete-item text-decoration-none text-danger"
                                                        href="{{ route('admin.role-user.destroy', $product->id) }}">
                                                        <i class="ti ti-trash fs-1"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No product found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>

                        <div class="card-footer">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('.resend-mail').on('click', function(e) {
                    e.preventDefault();
                    console.log("Resend Mail clicked");
                    const url = $(this).attr('href');

                    // console.log(url);

                    $.ajax({
                        url: url,
                        type: "GET",
                        beforeSend: function() {
                            $(this).addClass('disable');
                        },
                        success: function(res) {
                            console.log(res);
                            if (res.status === 'error') {
                                Swal.fire(
                                    'Error!',
                                    res.message,
                                    'error'
                                );

                                $(this).removeClass('disable');
                                return;
                            }

                            Swal.fire(
                                'Success!',
                                res.message,
                                'success'
                            );

                            $(this).removeClass('disable');
                        },
                        error: function(xhr) {
                            xhr = JSON.parse(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                xhr.message,
                                'error'
                            );

                            $(this).removeClass('disable');
                        }
                    });
                });
            })
        </script>
    @endpush
@endsection
