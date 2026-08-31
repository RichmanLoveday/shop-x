@extends('admin.layout.app')

@section('contents')

<div class="container-xl">

    <div class="row row-deck row-cards space-y-4">

        <div class="col-12">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Edit Shipping Method
                    </h3>

                    <div class="card-actions">

                        <a href="{{ route('admin.shipping-methods.index') }}"
                            class="btn btn-primary btn-3">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-2">

                                <path d="M9 6l-6 6l6 6" />
                                <path d="M3 12h18" />

                            </svg>

                            Back

                        </a>

                    </div>

                </div>


                <div class="card-body">

                    <form action="{{ route('admin.shipping-methods.update', $shippingMethod->id) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Method Name --}}
                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label required">
                                        Shipping Method Name
                                    </label>

                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $shippingMethod->name) }}"
                                        placeholder="e.g. Standard Shipping"
                                        required>

                                    <small class="form-hint">
                                        The name customers will see when selecting a delivery method.
                                    </small>

                                    <x-input-error :messages="$errors->get('name')" />

                                </div>

                            </div>


                            {{-- Code --}}
                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label required">
                                        Code
                                    </label>

                                    <input type="text"
                                        name="code"
                                        id="shippingCode"
                                        class="form-control"
                                        value="{{ old('code', $shippingMethod->code) }}"
                                        placeholder="e.g. standard"
                                        required>

                                    <small class="form-hint">
                                        A unique system identifier such as
                                        <code>standard</code> or <code>express</code>.
                                    </small>

                                    <x-input-error :messages="$errors->get('code')" />

                                </div>

                            </div>


                            {{-- Minimum Delivery Days --}}
                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label required">
                                        Minimum Delivery Days
                                    </label>

                                    <input type="number"
                                        name="min_days"
                                        class="form-control"
                                        value="{{ old('min_days', $shippingMethod->min_days) }}"
                                        min="0"
                                        max="365"
                                        placeholder="e.g. 3"
                                        required>

                                    <small class="form-hint">
                                        The earliest expected delivery time.
                                    </small>

                                    <x-input-error :messages="$errors->get('min_days')" />

                                </div>

                            </div>


                            {{-- Maximum Delivery Days --}}
                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label required">
                                        Maximum Delivery Days
                                    </label>

                                    <input type="number"
                                        name="max_days"
                                        class="form-control"
                                        value="{{ old('max_days', $shippingMethod->max_days) }}"
                                        min="0"
                                        max="365"
                                        placeholder="e.g. 5"
                                        required>

                                    <small class="form-hint">
                                        The latest expected delivery time.
                                    </small>

                                    <x-input-error :messages="$errors->get('max_days')" />

                                </div>

                            </div>


                            {{-- Active --}}
                            <div class="col-md-12">

                                <div class="mb-3 mt-3">

                                    <label class="form-check form-switch">

                                        <input type="checkbox"
                                            class="form-check-input"
                                            name="is_active"
                                            value="1"
                                            {{ old('is_active', $shippingMethod->is_active) ? 'checked' : '' }}>

                                        <span class="form-check-label">
                                            Active
                                        </span>

                                    </label>

                                    <small class="text-muted">
                                        Active shipping methods can be configured for shipping routes
                                        and selected by customers during checkout.
                                    </small>

                                    <x-input-error :messages="$errors->get('is_active')" />

                                </div>

                            </div>

                        </div>


                        {{-- Delivery Preview --}}
                        <div class="alert alert-info mt-3">

                            <div class="d-flex">

                                <div>

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon alert-icon">

                                        <path d="M12 9v4" />
                                        <path d="M12 17v.01" />
                                        <path d="M10.24 3.58l-8.32 14a2 2 0 0 0 1.72 3h16.72a2 2 0 0 0 1.72 -3l-8.32 -14a2 2 0 0 0 -3.52 0z" />

                                    </svg>

                                </div>

                                <div>

                                    <h4 class="alert-title">
                                        Shipping method pricing
                                    </h4>

                                    <div class="text-secondary">
                                        Delivery charges are not configured here.
                                        Shipping rates are configured separately for specific
                                        origin and destination zones.
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Submit --}}
                        <div class="text-end mt-4">

                            <a href="{{ route('admin.shipping-methods.index') }}"
                                class="btn btn-link">

                                Cancel

                            </a>

                            <button class="btn btn-primary"
                                type="submit">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-2">

                                    <path d="M5 12l5 5l10 -10" />

                                </svg>

                                Update Shipping Method

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
