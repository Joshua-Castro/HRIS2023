@extends('layouts.main')

@section('content')
<div class="row" x-data="adminDashboard()">
    <div class="col-sm-12">
      <div class="home-tab">
        <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Issues (2)</a>
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
                      <div class="card">
                        <div class="card-body">
                          <div>
                            <p class="card-title card-title-dash font-weight-medium">Leave Requests</p>
                            <h3 class="rate-percentage d-flex justify-content-between align-items-center">36<span class="text-danger text-medium d-flex align-items-center"><i class="mdi mdi-trending-down me-2 icon-md"></i>-12%</span></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3 grid-margin">
                      <div class="card">
                        <div class="card-body">
                          <div>
                            <p class="card-title card-title-dash font-weight-medium">New employees</p>
                            <h3 class="rate-percentage d-flex justify-content-between">124<span class="text-success text-medium d-flex align-items-center"><i class="mdi mdi-trending-up me-2 icon-md"></i>+30%</span></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-3 grid-margin">
                      <div class="card">
                        <div class="card-body">
                          <div>
                            <p class="card-title card-title-dash font-weight-medium">Happines rate</p>
                            <h3 class="rate-percentage  d-flex justify-content-between">352<span class="text-danger text-medium d-flex align-items-center"><i class="mdi mdi-trending-up me-2 icon-md "></i>-24%</span></h3>
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
                                        <input type="hidden" name="name" value="">
                                        <input type="hidden" name="status" value="all">
                                        <input type="hidden" name="pagination" value="10">
                                        <input type="hidden" name="page" value="1">
                                    </form>
                                    <div class="col-md-5 mb-2 mb-lg-0">
                                        <div class="input-group">
                                            <input id="users-search-keyword" type="text" class="form-control form-control-sm"
                                                name="search-keyword" placeholder="Name">
                                            <button id="users-search"
                                                class="btn input-group-text btn-secondary border waves-effect py-0 px-2 form-control form-control-sm"
                                                type="button">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-lg-0" style="padding-top: 1px;">
                                        <select id="users-filter" class="form-select form-select-sm bg-soft-secondary fw-bold">
                                            <option value="all" selected>All Accounts</option>
                                            <option value="active">Male</option>
                                            <option value="disabled">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 1px;">
                                        <select id="users-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
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
                          <table id="order-listing" class="table table-sm">
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
                                                    {{-- <button class="btn btn-sm btn-info" @click="editPatientVaccination(indexData)" title="Edit" type="button"><i class="fas fa-edit" style="width:12px;height:12px;"></i></button>
                                                    <button class="btn btn-sm btn-danger" @click="deletePatientVaccinationRecord(indexData)" title="Delete" type="button"><i class="fas fa-trash-alt"  style="width:12px;height:12px;"></i></button> --}}
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
            <h3>EMPLOYEE TAB</h3>
            @endif
          </div>
          <div class="tab-pane fade show" id="audiences" role="tabpanel" aria-labelledby="audiences"> 
            <div class="row">
              <div class="col-lg-12 d-flex flex-column">
                <div class="row flex-grow">
                  <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                      <div class="card-body">
                        <h4 class="card-title card-title-dash">Recruitment Progress</h4>
                        <div class="table-responsive  mt-1">
                          <table class="table select-table">
                            <thead>
                              <tr>
                                <th><p class="dark-text fs-14">Candidate Name</p></th>
                                <th><p class="dark-text fs-14">Email Address</p></th>
                                <th><p class="dark-text fs-14">Contact Number</p></th>
                                <th><p class="dark-text fs-14">Job Title</p></th>
                                <th><p class="dark-text fs-14">Recruitment Status</p></th>
                                <th><p class="dark-text fs-14"><p></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <p class="dark-text fs-14">
                                    <div class="d-flex align-items-center">
                                      <img class="img-sm rounded" src="{{ asset('template/images/faces/face2.jpg') }}" alt="profile">
                                      <div>
                                        <p class="dark-text fs-14">Ebin Sunny</p>
                                      </div>
                                    </div>
                                  </p>
                                </td>
                                <td><p class="dark-text fs-14">robinanderson@gmail.com</p></td>
                                <td><p class="dark-text fs-14">+91 9456782446</p> </td>
                                <td><p class="dark-text fs-14">UI UX Designer</p></td>
                                <td><div class="badge badge-outline-success rounded">2nd Round</div></td>
                                <td><p class="dark-text fs-14"><i class="mdi mdi-dots-horizontal"></i></p></td>
                              </tr>
                              <tr>
                                <td>
                                  <p class="dark-text fs-14">
                                    <div class="d-flex align-items-center">
                                      <img class="img-sm rounded" src="{{ asset('template/images/faces/face3.jpg') }}" alt="profile">
                                      <div>
                                        <p class="dark-text fs-14">Julia Gomez</p>
                                      </div>
                                    </div>
                                  </p>
                                </td>
                                <td><p class="dark-text fs-14">julia123gomez@gmail.com</p></td>
                                <td><p class="dark-text fs-14">+91 9456782446</p> </td>
                                <td><p class="dark-text fs-14">Software Developer</p></td>
                                <td><div class="badge badge-outline-info rounded">Machine Test</div></td>
                                <td><p class="dark-text fs-14"><i class="mdi mdi-dots-horizontal"></i></p></td>
                              </tr>
                              <tr>
                                <td>
                                  <p class="dark-text fs-14">
                                    <div class="d-flex align-items-center">
                                      <img class="img-sm rounded" src="{{ asset('template/images/faces/face4.jpg') }}" alt="profile">
                                      <div>
                                        <p class="dark-text fs-14">Taison Joe</p>
                                      </div>
                                    </div>
                                  </p>
                                </td>
                                <td><p class="dark-text fs-14">1010taison@gmail.com</p></td>
                                <td><p class="dark-text fs-14">+91 9456782446</p> </td>
                                <td><p class="dark-text fs-14">Finance Manager</p></td>
                                <td><div class="badge badge-outline-secondary rounded">Final Round</div></td>
                                <td><p class="dark-text fs-14"><i class="mdi mdi-dots-horizontal"></i></p></td>
                              </tr>
                              <tr>
                                <td>
                                  <p class="dark-text fs-14">
                                    <div class="d-flex align-items-center">
                                      <img class="img-sm rounded" src="{{ asset('template/images/faces/face5.jpg') }}" alt="profile">
                                      <div>
                                        <p class="dark-text fs-14">Kiya Johnson </p>
                                      </div>
                                    </div>
                                  </p>
                                </td>
                                <td><p class="dark-text fs-14">kiyajohnson@gmail.com</p></td>
                                <td><p class="dark-text fs-14">+91 9456782446</p> </td>
                                <td><p class="dark-text fs-14">SEO Specialist</p></td>
                                <td><div class="badge badge-outline-primary rounded">2nd Round</div></td>
                                <td><p class="dark-text fs-14"><i class="mdi mdi-dots-horizontal"></i></p></td>
                              </tr>
                              <tr>
                                <td>
                                  <p class="dark-text fs-14">
                                    <div class="d-flex align-items-center">
                                      <img class="img-sm rounded" src="{{ asset('template/images/faces/face6.jpg') }}" alt="profile">
                                      <div>
                                        <p class="dark-text fs-14">Allen Bravo </p>
                                      </div>
                                    </div>
                                  </p>
                                </td>
                                <td><p class="dark-text fs-14">allen324200@gmail.com</p></td>
                                <td><p class="dark-text fs-14">+91 9456782446</p> </td>
                                <td><p class="dark-text fs-14">Android Developer</p></td>
                                <td><div class="badge badge-outline-info rounded">1st Round</div></td>
                                <td><p class="dark-text fs-14"><i class="mdi mdi-dots-horizontal"></i></p></td>
                              </tr>
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
    @include('modals.employe-modal')
</div>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    @if (auth()->user()->is_admin == 1)
                        {{ __('Hello Admin!') }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/dashboard.js') }}"></script>
@endpush
