@extends('layouts.main')

@section('content')
<div class="row" x-data="leaveRequest()">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-style-border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title card-title-dash">Leave Requests</h4>
                                <p class="text-small modern-color-999">See all of your employees Leave Request here...</p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <form id="users-search-form" class="d-none">
                                    <input type="hidden" name="name" x-ref="employeeInput">
                                    <input type="hidden" name="status">
                                    <input type="hidden" name="pagination">
                                    <input type="hidden" name="page">
                                </form>
                                <div class="input-group me-2" style="width: 280px;">
                                    <input id="users-search-keyword" type="text" class="form-control form-control-sm" name="search-keyword" placeholder="Employee Number / Name" x-model="searchEmployee" @keydown="employeeSearchPayroll">
                                    <div class="input-group-append">
                                        <button id="users-search" x-ref="usersSearchButton" class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark" @click="getEmployeeDataPayroll" type="button" style="border-end-start-radius: 0px; border-start-start-radius: 0px;">Search</button>
                                    </div>
                                </div>
                                <select id="payroll-filter" class="form-select form-select-sm bg-soft-secondary fw-bold me-2" x-model="filter" style="border-radius: 5px; width: 150px; height: 31.6px;" @change="getEmployeeDataPayroll">
                                    <option value="all">All Employees</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <select id="payroll-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="pagination" style="border-radius: 5px; width: 80px; height: 31.6px;" @change="getEmployeeDataPayroll">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
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
                                                        <div class="badge badge-warning" x-text="rows.status" style="border-radius: 5px;"></div>
                                                    </template>
                                                    <template x-if="rows.status == 'Accepted'">
                                                        <div class="badge badge-success" x-text="rows.status" style="border-radius: 5px;"></div>
                                                    </template>
                                                    <template x-if="rows.status == 'Declined'">
                                                        <div class="badge badge-danger" x-text="rows.status" style="border-radius: 5px;"></div>
                                                    </template>
                                                </td>
                                                <template x-if="rows.status === 'Pending'">
                                                    <td class="text-center" style="padding-top: 18px;">
                                                        <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton13" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-lg fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton13">
                                                            <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="viewRequest(indexData)">
                                                                <i class="ti-eye btn-icon-prepend me-2"></i>
                                                                View
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="updateRequest(indexData, 'Accepted')">
                                                                <i class="ti-check-box btn-icon-prepend me-2"></i>
                                                                Accept
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="updateRequest(indexData, 'Declined')">
                                                                <i class="ti-close btn-icon-prepend me-2"></i>
                                                                Decline
                                                            </a>
                                                        </div>
                                                    </td>
                                                </template>
                                                <template x-if="rows.status != 'Pending'">
                                                    <td class="text-center" style="padding-top: 18px;">
                                                        <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton13" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-lg fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton13">
                                                            <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="viewRequest(indexData)">
                                                                <i class="ti-eye btn-icon-prepend me-2"></i>
                                                                View
                                                            </a>
                                                        </div>
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
