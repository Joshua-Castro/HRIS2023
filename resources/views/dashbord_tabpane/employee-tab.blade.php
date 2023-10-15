@if(auth()->user()->is_admin == 1)
@push('styles')
    <style>
        .filepond--credits {
            display: none;
        }
    </style>
@endpush
<div class="row" @loademployeedata.window="getEmployeeInit">
    <div class="col-xl-12 col-lg-12 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-xl-6 order-2 order-md-1 my-auto">
                                <div>
                                    <h4 class="card-title card-title-dash">Employees</h4>
                                    <p class="text-small modern-color-999">All of your employee details are here...</p>
                                </div>
                            </div>
                            <div class="col-lg-9 col-xl-6 order-1 order-md-2 mb-2 mb-md-0">
                                <div class="row gx-1">
                                    <form id="users-search-form" class="d-none">
                                        <input type="hidden" name="name" x-ref="nameInput">
                                        <input type="hidden" name="status">
                                        <input type="hidden" name="pagination">
                                        <input type="hidden" name="page">
                                    </form>
                                    <div class="col-md-4 mb-2 mb-lg-0">
                                        <div class="input-group">
                                            <input id="users-search-keyword" type="text" class="form-control form-control-sm"
                                                name="search-keyword" placeholder="Name" x-model="searchName" @keydown="inputSearch">
                                            <div class="input-group-append">
                                                <button id="users-search"
                                                class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark"
                                                type="button" x-ref="usersSearchButton" @click="getEmployeeData" style="border-end-start-radius: 0px; border-start-start-radius: 0px;">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-lg-0" style="padding-top: 1px;">
                                        <select id="users-filter" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="filter" @change="getEmployeeData">
                                            <option value="all">All Employees</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 1px;">
                                        <select id="users-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="pagination" @change="getEmployeeData">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 1px;">
                                        <button id="users-search" class="btn input-group-text btn-outline-primary border waves-effect py-0 px-2 form-control form-control-sm" type="button" @click="create">Add</button>
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
                                <th>Station Code</th>
                                <th>Employment Status</th>
                                <th>School Code</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <template x-if="isLoading">
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
                        <template x-if="!isLoading">
                            <tbody>
                                <template x-if="(employeeData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="6"><i class="fa fa-info-circle"></i> There is no employee's record.</td>
                                    </tr>
                                </template>
                                <template x-if="(employeeData ?? []).length > 0">
                                    <template x-for="(rows, indexData) in employeeData">
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img class="img-sm rounded mb-2" x-bind:src="'storage/' + rows.image_filepath" alt="profile">
                                                    <div class="ms-2">
                                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0" x-text="rows.first_name + ' ' + (rows.middle_name ?? '') + ' ' + rows.last_name"></p>
                                                        <p class="text-muted text-small" x-text="rows.position"></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><p class="dark-text fs-14" x-text="rows.employee_no"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.station_code"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.employment_status"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.school_code"></p></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-lg fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                                                    <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="edit(indexData, 'edit')">
                                                        <i class="ti-pencil btn-icon-prepend me-2"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="edit(indexData, 'view')">
                                                        <i class="ti-eye btn-icon-prepend me-2"></i>
                                                        View
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="remove(indexData)">
                                                        <i class="ti-trash btn-icon-prepend me-2"></i>
                                                        Delete
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="uploadFile(rows.employee_id, rows.employee_token)">
                                                        <i class="ti-cloud-up btn-icon-prepend me-2"></i>
                                                        Upload
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="viewFiles(rows.employee_id)">
                                                        <i class="ti-files btn-icon-prepend me-2"></i>
                                                        Files
                                                    </a>
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
                                    <p id="user-counter" class="m-0">No accounts to display</p>
                                </div>
                                <div class="col-md-6">
                                    <nav>
                                        <ul class="pagination pagination-rounded float-md-end mt-2 mb-0">
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
@include('modals.employee-file-upload')
@include('modals.view-employee-uploaded-files')
@endif
