@extends('layouts.main')

@section('content')
<div class="row" x-data="adminDashboard()">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Hirings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#demographics" role="tab" aria-selected="false">Employees</a>
            </li>
            <li class="nav-item">
              <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
            </li>
          </ul>
        </div>
        <div class="tab-content tab-content-basic">
          <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
            @if(auth()->user()->is_admin == 1) 
            <div class="row">
              <div class="col-sm-12">
                <div class="statistics-details mb-0">
                  <div class="row">
                   <div class="col-sm-3 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <div>
                          <p class="card-title card-title-dash font-weight-medium">Total employees</p>
                          <h3 class="rate-percentage d-flex justify-content-between" x-text="employeeCount"></h3>
                        </div>
                      </div>
                    </div>
                   </div>
                    <div class="col-sm-3 grid-margin">
                      <a href="{{ route('request') }}" style="text-decoration: none !important; color: inherit;">
                        <div class="card">
                          <div class="card-body">
                            <div>
                              <p class="card-title card-title-dash font-weight-medium">Leave Requests</p>
                              <h3 class="rate-percentage d-flex justify-content-between align-items-center" x-text="overAllLeaveCount"></h3>
                            </div>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col-sm-3 grid-margin">
                      <div class="card">
                        <div class="card-body">
                          <div>
                            <p class="card-title card-title-dash font-weight-medium">New employees</p>
                            <h3 class="rate-percentage d-flex justify-content-between">SOON</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3 grid-margin">
                      <div class="card">
                        <div class="card-body">
                          <div>
                            <p class="card-title card-title-dash font-weight-medium">Overtime Requests</p>
                            <h3 class="rate-percentage  d-flex justify-content-between">SOON</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12 col-lg-12 d-flex flex-column">
                <div class="row flex-grow">
                  <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                      <div class="card-body">
                        {{-- <div class="align-items-start">
                          <div class="d-flex justify-content-between">
                            <h4 class="card-title card-title-dash">Employees</h4>
                            <button class="btn btn-sm btn-outline-primary employee-btn" @click="create">Add Employee</button>
                          </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-lg-3 col-xl-6 order-2 order-md-1 my-auto">
                                <h4 class="card-title card-title-dash">Employees</h4>
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
                                            <button id="users-search"
                                                class="btn input-group-text btn-secondary border waves-effect py-0 px-2 form-control form-control-sm"
                                                type="button" x-ref="usersSearchButton" @click="getEmployeeData">Search</button>
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
                        <div class="table-responsive mt-1">
                        <table class="table table-sm table-hover">
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
                                    <td class="text-center" colspan="10"><div class="spinner-border"></div></td>
                                </tr>
                            </tbody>
                        </template>
                        <template x-if="!isLoading">
                            <tbody>
                                <template x-if="(employeeData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="6"><i class="fas fa-info-circle"></i> There is no employee's record.</td>
                                    </tr>
                                </template>
                                <template x-if="(employeeData ?? []).length > 0">
                                    <template x-for="(rows, indexData) in employeeData">
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
                                            <td><p class="dark-text fs-14" x-text="rows.station_code"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.employment_status"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.school_code"></p></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm action-btn btn-outline-info" @click="edit(indexData, 'edit')" title="Edit">Edit</button>
                                                <button type="button" class="btn btn-sm action-btn btn-outline-primary" @click="edit(indexData, 'view')">View</button>
                                                <button type="button" class="btn btn-sm action-btn btn-outline-danger" @click="remove(indexData)">Delete</button>
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
                                        <ul class="pagination pagination-rounded float-md-end mb-0">
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
            @else
            <div class="row">
                <div class="col-sm-12">
                  <div class="statistics-details mb-0">
                    <div class="row">
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title card-title-dash font-weight-medium">Current Time</p>
                                    <template x-if="timeLoading">
                                        <div class="spinner-border"></div>
                                    </template>
                                    <h3 class="rate-percentage d-flex justify-content-between text-primary" x-text="currentTime"></h3>
                                    {{-- <span class="text-danger text-medium d-flex align-items-center" x-text="currentTime"></span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                        <div class="card">
                            <div class="card-body">
                            <div>
                                <p class="card-title card-title-dash font-weight-medium">Leave Requests</p>
                                <h3 class="rate-percentage d-flex justify-content-between" x-text="leaveCount"></h3>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <div>
                                <p class="card-title card-title-dash font-weight-medium">WFH Requests</p>
                                <h3 class="rate-percentage d-flex justify-content-between align-items-center">SOON<span class="text-danger text-medium d-flex align-items-center"><i class="mdi mdi-trending-down me-2 icon-md"></i></span></h3>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-3 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <div>
                                <p class="card-title card-title-dash font-weight-medium">Overtime Requests</p>
                                <h3 class="rate-percentage d-flex justify-content-between">SOON<span class="text-success text-medium d-flex align-items-center"><i class="mdi mdi-trending-up me-2 icon-md"></i></span></h3>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 d-flex flex-column">
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                        <div class="align-items-start">
                            <div class="d-flex justify-content-between">
                              <h4 class="card-title card-title-dash">Leave Requests</h4>
                              <button class="btn btn-sm btn-outline-primary employee-btn" @click="createRequest">Request</button>
                            </div>
                        </div>
                        <div class="table-responsive mt-1">
                        <table class="table table-sm table-hover">
                        <thead>
                              <tr class="text-center">
                                <th>Leave Date</th>
                                <th>Leave Type</th>
                                <th>Day Type</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                              </tr>
                        </thead>
                        <template x-if="leaveIsLoading">
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="5"><div class="spinner-border"></div></td>
                                </tr>
                            </tbody>
                        </template>
                        <template x-if="!leaveIsLoading">
                            <tbody>
                                <template x-if="(leaveData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="5"><i class="fas fa-info-circle"></i> There Leave Request's record.</td>
                                    </tr>
                                </template>
                                <template x-if="(leaveData ?? []).length > 0">
                                    <template x-for="(rows, indexData) in leaveData">
                                        <tr class="text-center">
                                            <td><p class="dark-text fs-14" x-text="rows.leave_date"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.leave_type"></p></td>
                                            <td><p class="dark-text fs-14" x-text="rows.day_type"></p></td>
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
                                                {{-- <p class="dark-text fs-14" ></p> --}}
                                            </td>
                                            <td class="text-center" style="padding-top: 28px;">
                                                <button type="button" class="btn btn-sm action-btn btn-outline-info" @click="editLeaveRequest(indexData)" title="Edit">Edit</button>
                                                <button type="button" class="btn btn-sm action-btn btn-outline-danger" @click="removeLeaveRequest(indexData)">Delete</button>
                                            </td>
                                        </tr>
                                    </template>
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
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    @include('modals.employe-modal')
    @include('modals.leave-request-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/dashboard.js') }}"></script>
@endpush
