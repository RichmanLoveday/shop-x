@extends('frontend.layout.app')
@section('contents')
    <x-frontend.breadcrumb :items="[['url' => '/', 'label' => 'Home'], ['url' => route('kyc.index'), 'label' => 'Kyc Verification']]" />

    <div class="page-content pt-150 pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-10 col-lg-12 col-md-9 m-auto">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h2 class="mb-5 capitalize">Kyc Verification</h2>
                                    </div>
                                    <form class="mt-50" method="post" action="{{ route('kyc.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" required="" id="full_name"
                                                value="{{ old('full_name') }}" name="full_name" />
                                            <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                                        </div>


                                        <div class="form-group">
                                            <label for="date">Date of Birth <span class="text-danger">*</span></label>
                                            <input required="" id="date" name="dob"
                                                class="datepicker" />
                                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <label for="full_address">Full Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" required="" id="full_address"
                                                value="{{ old('full_address') }}" name="full_address" />
                                            <x-input-error :messages="$errors->get('full_address')" class="mt-2" />
                                        </div>


                                        <div class="form-group">
                                            <label for="document_type">Document Type <span
                                                    class="text-danger">*</span></label>
                                            <select name="document_type" id="document_type" class="form-control">
                                                <option value="">--- select document type ---</option>
                                                <option value="id_card">ID Card</option>
                                                <option value="passport">Passport</option>
                                                <option value="driving_license">Driving License</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('document_type')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <label for="document_scan_copy">Document Scan Copy <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" required="" id="document_scan_copy"
                                                name="document_scan_copy" />
                                            <x-input-error :messages="$errors->get('document_scan_copy')" class="mt-2" />
                                        </div>

                                        <div class="form-group mb-0">
                                            <button id="loginBtn" type="submit"
                                                class="btn btn-fill-out btn-block hover-up font-weight-bold">Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
