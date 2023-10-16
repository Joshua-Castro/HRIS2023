@extends('layouts.main')

@section('content')
<div class="row" x-data="leaveRequest()">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="card-title card-title-dash">Leave Requests</h4>
                                <p class="text-small modern-color-999">See all of your employees Leave Request here...</p>
                            </div>
                        </div>
                        <div class="table-sm table-responsive mt-1">
                            <table class="table table-striped table-bordered">
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
                                <template x-if="adminLeaveLoading">
                                    <tbody>
                                        <tr>
                                            <td class="text-center" colspan="10">
                                                <div class="spinner-container">
                                                    <div class="spinner"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                                <template x-if="!adminLeaveLoading">
                                    <tbody>
                                        <template x-if="(leaveData ?? []).length == 0">
                                            <tr class="text-center">
                                                <td class="" colspan="6"><i class="fa fa-info-circle"></i> There is no leave request's record.</td>
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
                                </template>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('modals.view-employee-request-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/leave-request.js') }}"></script>
@endpush
