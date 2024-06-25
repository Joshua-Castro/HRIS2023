@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-style-border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title card-title-dash">Generated Payroll</h4>
                                <p class="text-small modern-color-999">You can see and edit the generated payroll here...</p>
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
                                    <th>Position</th>
                                    <th>Payroll Date From</th>
                                    <th>Payroll Date To</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
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
                            {{-- <template x-if="!loadingPayroll">
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
                            </template> --}}
                            </table>
                            <div class="row gx-0">
                                <div class="col-md-6 mb-2 my-md-auto">
                                    <p id="employee-counter" class="m-0">No accounts to display</p>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="payroll-generated-pagination pagination pagination-sm float-md-end mt-2 mb-0">
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
@endsection
@push('scripts')
    {{-- <script src="{{ asset('template/pages-js/payroll.js') }}"></script> --}}
@endpush
