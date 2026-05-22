@extends('frontend.dashboard.dashboard-app')
@section('dashboard_contents')
    <div class="tab-pane fade active show" id="address" role="tabpanel" aria-labelledby="address-tab">
        <div class="wsus__shipping_address mb_40">
            <h4>Billing Address
                <a href="{{ route('address.create') }}" class="btn btn-primary">add new address</a>
            </h4>

            <div class="row">
                @foreach ($addresses as $address)
                    <x-frontend.billing-address :address="$address" :showEditDelete="true" />
                @endforeach
            </div>

            <div class="panel-collapse collapse login_form" id="loginform">
                <div class="panel-body">
                    <h4>Add New Address</h4>
                    <form>
                        <div class="row mt-20">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Name ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" placeholder="Email ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" placeholder="Phone ">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea placeholder="Address" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-md" name="login">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.address-card').on('click', function(e) {
                    // ignore edit/delete clicks
                    if ($(e.target).closest('a').length) return;

                    let id = $(this).data('id');

                    let radio = $(this).find('.default-address');

                    radio.prop('checked', true).trigger('change');

                });

                // update default address
                $('.default-address').on('change', function() {

                    let id = $(this).data('id');

                    $.ajax({
                        url: route('address.set-default', [id]),
                        method: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },

                        success: function(res) {
                            if (res.status) {
                                notyf.success(res.message || 'Default address updated');
                            } else {
                                notyf.error(res.message || 'Something went wrong');
                            }
                        },

                        error: function() {
                            notyf.error('Failed to update address');
                        }
                    });

                });


            });
        </script>
    @endpush
@endsection
