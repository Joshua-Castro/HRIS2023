@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-xl-6 order-2 order-md-1 my-auto">
                                <div>
                                    <h4 class="card-title card-title-dash">Generate Payroll</h4>
                                    <p class="text-small modern-color-999">You can generate your employee's payroll here...</p>
                                </div>
                            </div>
                            <div class="col-lg-9 col-xl-6 order-1 order-md-2 mb-2 mb-md-0">
                                <div class="row gx-2">
                                    <form id="employee-search-form" class="d-none">
                                        <input type="hidden" name="name" x-ref="nameInput">
                                        <input type="hidden" name="status">
                                        <input type="hidden" name="pagination">
                                        <input type="hidden" name="page">
                                    </form>
                                    <div class="col-md-6 mb-2 mb-lg-0">
                                        <div class="input-group">
                                            <input id="employee-search-keyword" type="text" class="form-control form-control-sm"
                                                name="search-keyword" placeholder="Name">
                                            <div class="input-group-append">
                                                <button id="employee-search"
                                                class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark"
                                                type="button" style="border-end-start-radius: 0px; border-start-start-radius: 0px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-lg-0" style="padding-top: 1px;">
                                        <select id="employee-filter" class="form-select form-select-sm bg-soft-secondary fw-bold">
                                            <option value="all">All Employees</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 1px;">
                                        <select id="employee-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
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
                                        <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-lg fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                                            <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);">
                                                <i class="ti-pencil btn-icon-prepend me-2"></i>
                                                Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                <i class="ti-eye btn-icon-prepend me-2"></i>
                                                View
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                <i class="ti-trash btn-icon-prepend me-2"></i>
                                                Delete
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                <i class="ti-cloud-up btn-icon-prepend me-2"></i>
                                                Upload
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                <i class="ti-files btn-icon-prepend me-2"></i>
                                                Files
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                                <div class="row gx-0">
                                    <div class="col-md-6 mb-2 my-md-auto">
                                        <p id="user-counter" class="m-0">No accounts to display</p>
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
    </div>
</div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('template/pages-js/activity.js') }}"></script> --}}
@endpush
