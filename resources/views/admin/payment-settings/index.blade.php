@extends('admin.layout.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-md-3 border-end">
                    <div class="card-body">
                        <h4 class="subheader">Payment Settings</h4>
                        <div class="list-group list-group-transparent">
                            <a href="{{ route('admin.payment-settings.stripe.index') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center active">Stripe
                                Settings</a>
                        </div>

                        <div class="list-group list-group-transparent">
                            <a href="{{ route('admin.payment-settings.paystack.index') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">Paystack
                                Settings</a>
                        </div>

                        <div class="list-group list-group-transparent">
                            <a href="{{ route('admin.payment-settings.flutterwave.index') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center">Flutterwave
                                Settings</a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-9 d-flex flex-column">
                    @yield('payment_settings_contents')
                </div>
            </div>
        </div>
    </div>
@endsection
