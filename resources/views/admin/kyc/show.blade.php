@extends('admin.layout.app')
@section('contents')
    <div class="container-xl">
        <div class="row row-deck row-cards space-y-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Kyc Requests</h3>
                        <div class="card-actions">
                            <a href="#" class="btn btn-primary btn-3">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-2">
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <tbody>
                                    <tr>
                                        <td>Full Name</td>
                                        <td>{{ $kyc->full_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>{{ $kyc->dob ?? 'Null' }}</td>
                                    </tr>

                                    <tr>
                                        <td>Gender</td>
                                        <td>{{ $kyc->gender?->label() }}</td>
                                    </tr>

                                    <tr>
                                        <td>Full Address</td>
                                        <td>{{ $kyc->full_address }}</td>
                                    </tr>

                                    <tr>
                                        <td>Document Type</td>
                                        <td>{{ $kyc->document_type?->label() }}</td>
                                    </tr>

                                    <tr>
                                        <td>Document Scan Copy</td>
                                        <td>
                                            <a href="{{ route('admin.kyc.download', $kyc->id) }}"
                                                class="btn btn-primary">Download</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Status</td>
                                        <td> <span class="badge {{ $kyc->status->color() }}">
                                                {{ $kyc->status?->label() }}</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Change Status</td>
                                        <td>
                                            <form action="{{ route('admin.kyc.update', $kyc->id) }}" method="post">
                                                @csrf
                                                @method('PUT')

                                                <div class="input-group">
                                                    <select name="status" class="form-control" id="">
                                                        <option {{ $kyc->status == 'pending' ? 'selected' : '' }}
                                                            value="pending">Pending
                                                        </option>
                                                        <option {{ $kyc->status == 'under_review' ? 'selected' : '' }}
                                                            value="under_review">Under
                                                            Review
                                                        </option>
                                                        <option {{ $kyc->status == 'approved' ? 'selected' : '' }}
                                                            value="approved">Approved
                                                        </option>
                                                        <option {{ $kyc->status == 'rejected' ? 'selected' : '' }}
                                                            value="rejected">Rejected
                                                        </option>
                                                    </select>

                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
