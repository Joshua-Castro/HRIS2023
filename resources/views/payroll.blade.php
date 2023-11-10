@extends('layouts.main')

@section('content')
<div class="row" x-data="payroll()">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title card-title-dash">Generate Payroll</h4>
                                <p class="text-small modern-color-999">You can generate your employee's payroll here...</p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="input-group me-2" style="width: 280px;">
                                    <input id="users-search-keyword" type="text" class="form-control form-control-sm" name="search-keyword" placeholder="Employee Number / Name">
                                    <div class="input-group-append">
                                        <button id="users-search" class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark" type="button" style="border-end-start-radius: 0px; border-start-start-radius: 0px;">Search</button>
                                    </div>
                                </div>
                                <select id="payroll-filter" class="form-select form-select-sm bg-soft-secondary fw-bold me-2" style="border-radius: 5px; width: 150px; height: 31.6px;">
                                    <option value="all">All Employees</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <select id="payroll-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="currentPagination" style="border-radius: 5px; width: 80px; height: 31.6px;">
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
                                    <th>School Code</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pb-1 pt-2">
                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0">SAMPLE LONG NAME MD. LAST NAME</p>
                                        <p class="text-muted text-small">SAMPLE POSITION OF THE EMPLOYEE</p>
                                    </td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td class="text-center">
                                        <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;">
                                            <i class="ti-write btn-icon-prepend me-2"></i>
                                            Generate
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-1 pt-2">
                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0">SAMPLE LONG NAME MD. LAST NAME</p>
                                        <p class="text-muted text-small">SAMPLE POSITION OF THE EMPLOYEE</p>
                                    </td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td class="text-center">
                                        <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;">
                                            <i class="ti-write btn-icon-prepend me-2"></i>
                                            Generate
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-1 pt-2">
                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0">SAMPLE LONG NAME MD. LAST NAME</p>
                                        <p class="text-muted text-small">SAMPLE POSITION OF THE EMPLOYEE</p>
                                    </td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td class="text-center">
                                        <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;">
                                            <i class="ti-write btn-icon-prepend me-2"></i>
                                            Generate
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-1 pt-2">
                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0">SAMPLE LONG NAME MD. LAST NAME</p>
                                        <p class="text-muted text-small">SAMPLE POSITION OF THE EMPLOYEE</p>
                                    </td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td class="text-center">
                                        <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;">
                                            <i class="ti-write btn-icon-prepend me-2"></i>
                                            Generate
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-1 pt-2">
                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0">SAMPLE LONG NAME MD. LAST NAME</p>
                                        <p class="text-muted text-small">SAMPLE POSITION OF THE EMPLOYEE</p>
                                    </td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td><p class="dark-text fs-14">SAMPLE DATA</p></td>
                                    <td class="text-center">
                                        <div class="badge badge-outline-primary btn btn-sm btn-outline-primary" style="border-radius: 5px;">
                                            <i class="ti-write btn-icon-prepend me-2"></i>
                                            Generate
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                            <div class="row gx-0">
                                <div class="col-md-6 mb-2 my-md-auto">
                                    <p id="employee-counter" class="m-0">No accounts to display</p>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="pagination pagination-sm float-md-end mt-2 mb-0">
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
        <div class="row">
            <div class="col-lg-8 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title card-title-dash">Employee Attendance Details</h4>
                                        <p class="text-small modern-color-999">Choose the attendance of the employee to generate payroll...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

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
    <script src="{{ asset('template/pages-js/payroll.js') }}"></script>
@endpush
