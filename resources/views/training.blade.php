@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title card-title-dash">Training And Seminars</h4>
                        <p class="text-small modern-color-999">Manage your trainings and seminar schedule here...</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;">
                            <i class="ti ti-sm ti-filter me-2" style="font-size: 14px;"></i>
                            Filter
                        </button>
                        <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;">
                            Create
                        </button>
                    </div>
                </div>

                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pb-1 pt-2"> {{-- TO MAKE THE TABLE MORE COMPRESSED ADD CLASS IN THIS <td> 'class="pb-1 pt-2"' --}}
                                    <div class="d-flex align-items-center mt-0 mb-0 pt-0 pb-0">
                                        <div class="ms-2">
                                            <p class="dark-text fs-14 fw-bold mb-0 pb-0">Sample Training Title</p>
                                            <p class="text-muted text-small">Department that will have the training</p>
                                        </div>
                                    </div>
                                </td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row gx-0">
                        <div class="col-md-6 mb-2 my-md-auto">
                            <p id="attendance-counter" class="m-0">No trainings to display</p>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination pagination-rounded float-md-end mt-2 mb-0">
                                    {{-- PAGINATION --}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.training-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/training.js') }}"></script>
@endpush
