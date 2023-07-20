@extends('layouts.main')

@section('content')
@if (auth()->user()->is_admin == 1)
<div class="row" x-data="leaveRequest()">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Leave</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Overtime</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">WFH Request</a>
            </li>
            <li class="nav-item">
              <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
            </li>
          </ul>
        </div>
        <div class="tab-content tab-content-basic">
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                {{-- <div class="row">
                    <div class="col-sm-12">
                    <div class="statistics-details mb-0">
                        <div class="row">
                        <div class="col-sm-3 grid-margin">
                        <div class="card">
                            <div class="card-body">
                            <div>
                                <p class="card-title card-title-dash font-weight-medium">Leave Requests</p>
                                <h3 class="rate-percentage d-flex justify-content-between" x-text="leaveRequestCount"></h3>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <div>
                                <p class="card-title card-title-dash font-weight-medium">Overtime Requests</p>
                                <h3 class="rate-percentage d-flex justify-content-between align-items-center">SOON</h3>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <div>
                                <p class="card-title card-title-dash font-weight-medium">WFH Request</p>
                                <h3 class="rate-percentage d-flex justify-content-between">SOON</h3>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <div>
                                <p class="card-title card-title-dash font-weight-medium">Undertime Request</p>
                                <h3 class="rate-percentage  d-flex justify-content-between">SOON</h3>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-xl-12 col-lg-12 d-flex flex-column">
                      <div class="row flex-grow">
                        <div class="col-12 grid-margin stretch-card">
                          <div class="card card-rounded">
                            <div class="card-body">
                                <div class="align-items-start">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title card-title-dash">Leave Requests</h4>
                                </div>
                                </div>
                                <div class="table-responsive mt-1">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                            <th>Employee Name</th>
                                            <th>Employee Number</th>
                                            <th>Leave Date</th>
                                            <th>Leave Type</th>
                                            <th>Leave Status</th>
                                            <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-if="(leaveData ?? []).length == 0">
                                                <tr class="text-center">
                                                    <td class="" colspan="5"><i class="fa fa-info-circle"></i> There Leave Request's record.</td>
                                                </tr>
                                            </template>
                                            <template x-for="(rows, indexData) in leaveData">
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="dark-text fs-14 fw-bold mb-0 pb-0" x-text="rows.first_name + ' ' + (rows.middle_name ?? '') + ' ' + rows.last_name"></p>
                                                                <p class="text-muted text-small" x-text="rows.position"></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p class="dark-text fs-14" x-text="rows.employee_no"></p></td>
                                                    <td><p class="dark-text fs-14" x-text="rows.leave_date"></p></td>
                                                    <td><p class="dark-text fs-14" x-text="rows.leave_type"></p></td>
                                                    <td>
                                                        <template x-if="rows.status == 'Pending'">
                                                            <div class="badge badge-warning" x-text="rows.status"></div>
                                                        </template>
                                                        <template x-if="rows.status == 'Accepted'">
                                                            <div class="badge badge-success" x-text="rows.status"></div>
                                                        </template>
                                                        <template x-if="rows.status == 'Declined'">
                                                            <div class="badge badge-danger" x-text="rows.status"></div>
                                                        </template>
                                                        {{-- <p class="dark-text fs-14" x-text="rows.status"></p> --}}
                                                    </td>
                                                    <template x-if="rows.status === 'Pending'">
                                                        <td class="text-center" style="padding-top: 28px;">
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-primary" @click="viewRequest(indexData)">View</button>
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-info" @click="updateRequest(indexData, 'Accepted')">Accept</button>
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-danger" @click="updateRequest(indexData, 'Declined')">Decline</button>
                                                        </td>
                                                    </template>
                                                    <template x-if="rows.status != 'Pending'">
                                                        <td class="text-center" style="padding-top: 28px;">
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-primary" @click="viewRequest(indexData)">View</button>
                                                        </td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    @include('modals.view-employee-request-modal')
</div>
@endif
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/leave-request.js') }}"></script>
@endpush
