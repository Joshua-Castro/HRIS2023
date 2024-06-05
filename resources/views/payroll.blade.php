@extends('layouts.main')

@section('content')
<div class="row" x-data="payroll()">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-style-border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title card-title-dash">Setup Payroll</h4>
                                <p class="text-small modern-color-999">You can generate your employee's payroll here...</p>
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
                                    <th>Salary Grade</th>
                                    <th>Employment Status</th>
                                    <th>Position</th>
                                    <th class="text-center">Setup</th>
                                </tr>
                            </thead>
                            <template x-if="loadingPayroll">
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
                            <template x-if="!loadingPayroll">
                                <tbody>
                                    <template x-if="(employeePayrollData ?? []).length == 0">
                                        <tr class="text-center">
                                            <td class="" colspan="6"><i class="fa fa-info-circle"></i> There is no employee's record.</td>
                                        </tr>
                                    </template>
                                    <template x-if="(employeePayrollData ?? []).length > 0">
                                        <template x-for="(rows, indexData) in employeePayrollData">
                                            <tr>
                                                <td class="pb-1 pt-2">
                                                    <p class="dark-text fs-14 fw-bold mb-0 pb-0" x-text="rows.first_name + ' ' + (rows.middle_name ?? '') + ' ' + rows.last_name"></p>
                                                    <p class="text-muted text-small" x-text="rows.position"></p>
                                                </td>
                                                <td><p class="dark-text fs-14" x-text="rows.employee_no"></p></td>
                                                <td><p class="dark-text fs-14" x-text="rows.salary_grade"></p></td>
                                                <td><p class="dark-text fs-14" x-text="rows.employment_status"></p></td>
                                                <td><p class="dark-text fs-14" x-text="rows.position"></p></td>
                                                <td class="text-center">
                                                    <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;" @click="generatePayroll(rows.employee_id, indexData)">
                                                        <i class="ti-write btn-icon-prepend me-2"></i>
                                                        Setup Payroll
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </template>
                            </table>
                            <div class="row gx-0">
                                <div class="col-md-6 mb-2 my-md-auto">
                                    <p id="employee-counter" class="m-0">No accounts to display</p>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="employee-payroll-pagination pagination pagination-sm float-md-end mt-2 mb-0">
                                            {{-- pagination --}}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none payroll-row">
            <div class="col-lg-12 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card card-style-border">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title card-title-dash" x-text="employeeName + ' Attendance Details'"></h4>
                                        <p class="text-small modern-color-999">Choose the attendance of the employee to generate payroll...</p>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end">
                                        <form id="payroll-attendance-form" class="d-none">
                                            <input type="hidden" name="page" id="attendancePage">
                                            <input type="hidden" name="employeeId">
                                            <input type="hidden" name="dateFrom">
                                            <input type="hidden" name="dateTo">
                                        </form>
                                        <input type="text" id="payroll-date-from" name="payroll-date-from" class="form-control form-control-sm bg-white me-1 text-center fw-bold" placeholder="Date From :" x-model="dateFromVal" x-bind:value="dateFromVal" x-on:date-from-changed="filterAttendanceDetails" style="width: 200px;">
                                        <input type="text" id="payroll-date-to" name="payroll-date-to" class="form-control form-control-sm bg-white text-center fw-bold me-1" placeholder="Date To :" x-model="dateToVal" x-model="dateToVal" x-bind:value="dateToVal" x-on:date-to-changed="filterAttendanceDetails" style="width: 200px;">
                                        <button class="btn btn-sm btn-outline-success form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;">
                                            <i class="ti ti-sm ti-cloud-down me-2" style="font-size: 14px;"></i>
                                            CSV / PDF
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;" @click="showPayrollComputation">
                                            <i class="ti ti-sm ti-cloud-up me-2" style="font-size: 14px;"></i>
                                            Generate
                                        </button>
                                    </div>
                                </div>
                                <div class="table-sm table-responsive mt-1">
                                    <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th class="text-center">CLOCK IN</th>
                                            {{-- <th class="text-center">Break Out</th> --}}
                                            {{-- <th class="text-center">Break In</th> --}}
                                            <th class="text-center">CLOCK OUT</th>
                                            <th class="text-center">NOTES</th>
                                            <th class="text-center">WH</th>
                                            <th class="text-center">RWH</th>
                                            <th class="text-center">OTH</th>
                                        </tr>
                                    </thead>
                                    <template x-if="attendanceDetailsLoading">
                                        <tbody>
                                            <tr>
                                                <td class="text-center" colspan="8">
                                                    <div class="spinner-container">
                                                        <div class="spinner"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                    <template x-if="!attendanceDetailsLoading">
                                        <tbody>
                                            <template x-if="(attendancePayrollData ?? []).length == 0">
                                                <tr class="text-center">
                                                    <td class="" colspan="8"><i class="fa fa-info-circle"></i> There is no attendance record.</td>
                                                </tr>
                                            </template>
                                            <template x-if="(attendancePayrollData ?? []).length > 0">
                                                <template x-for="(rows, indexData) in attendancePayrollData">
                                                    <tr class="p-0">
                                                        <td x-text="rows.attendance_date"></td>
                                                        <td class="text-center py-0" x-text="(rows.clock_in  ? rows.clock_in  : '-')"></td>
                                                        <td class="text-center py-0" x-text="(rows.clock_out ? rows.clock_out : '-')"></td>
                                                        <td class="text-center py-0 text-wrap" x-text="(rows.notes ? rows.notes : '-')"></td>
                                                        <td class="text-center py-0" x-text="(rows.total_hours ? rows.total_hours : '-')"></td>
                                                        <td class="text-center py-0" x-text="(rows.regular_hours ? rows.regular_hours : '-')"></td>
                                                        <td class="text-center py-0" x-text="(rows.total_overtime_hours ? rows.total_overtime_hours : '-')"></td>
                                                    </tr>
                                                </template>
                                            </template>
                                        </tbody>
                                    </template>
                                    <thead x-show="(attendancePayrollData ?? []).length > 0">
                                        <tr>
                                            <th colspan="7" class="text-center fw-bold" style="letter-spacing: 5px; font-size: 16px;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody x-show="(attendancePayrollData ?? []).length > 0">
                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="text-center" x-text="totalHours ? totalHours : '-'"></td>
                                            <td class="text-center" x-text="regularHours ? regularHours : '-'"></td>
                                            <td class="text-center" x-text="otHours ? otHours : '-'"></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <div class="row gx-0">
                                        <div class="col-md-6 mb-2 my-md-auto">
                                            <p id="attendance-payroll-counter" class="m-0">No accounts to display</p>
                                        </div>
                                        <div class="col-md-6">
                                            <nav>
                                                <ul class="attendance-payroll-pagination pagination pagination-sm float-md-end mt-2 mb-0">
                                                    {{-- pagination --}}
                                                </ul>
                                            </nav>
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
    @include('modals.payroll-generate-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/payroll.js') }}"></script>
@endpush
