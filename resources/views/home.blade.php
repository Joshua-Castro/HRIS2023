@extends('layouts.main')

@push('styles')
    <style>
        /* STYLE FOR SELECT2 */
        .select2-container--bootstrap-5 .select2-selection--single {
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            height: 59px;
        }

        span.select2-selection.select2-selection--single {
            vertical-align: middle;
            padding-top: 16px;
        }

        /* STYLE FOR PROFILE CARD IN ADD EMPLOYEE */
        .profile-card {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            position: relative;
            margin: 50px;
            margin-top: 140px;
            width: 500px;
            height: 449px;
        }

        .circle {
            width: 200px;
            height: 200px;
            background-color: #616c74;
            border-radius: 50%;
            position: absolute;
            top: -100px;
            left: calc(40% - 40px);
        }
    </style>
@endpush

@section('content')
<div x-data="adminDashboard({{ auth()->user()->is_admin }})">
    @if(auth()->user()->is_admin == 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active ps-0" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="hiring-tab" data-bs-toggle="tab" href="#hiring" role="tab" aria-selected="false">Hirings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="employees-tab" data-bs-toggle="tab" href="#employees" role="tab" aria-selected="false" @click="dispatchCustomEvent">Employees</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link border-0" id="more-tab" data-bs-toggle="tab" href="#more" role="tab" aria-selected="false">More</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content tab-content-basic">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard">
                            @include('dashbord_tabpane.dashboard-tab')
                        </div>
                        <div class="tab-pane fade" id="hiring" role="tabpanel" aria-labelledby="hiring">
                            HIRING TAB
                        </div>
                        <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees">
                            @include('dashbord_tabpane.employee-tab')
                        </div>
                    </div>
                </div>
            </div>
            @include('modals.employe-modal')
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
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <template x-if="timeLoading">
                                                    <div class="spinner" style="width: 26px; height: 26px"></div>
                                            </template>
                                            <h3 class="rate-percentage text-primary" style="font-size: 24px;" x-text="currentTime"></h3>
                                        </div>
                                        <template x-if="!timeLoading">
                                            <div class="col-lg-6 col-md-12 d-flex justify-content-end">
                                                <button type="button" x-show="clockInBtn" class="btn btn-sm btn-primary btn-icon-text clock-in text-white" style="border-radius: 5px;" @click="webBundyFunction({{ auth()->user()->id }}, 'clock-in')" :disabled="webBundyLoading">
                                                    <i class="ti-alarm-clock btn-icon-prepend"></i>
                                                    Clock In
                                                </button>
                                                <button type="button" x-show="clockOutBtn" class="btn btn-sm btn-primary btn-icon-text clock-out text-white" style="border-radius: 5px;" @click="webBundyFunction({{ auth()->user()->id }}, 'clock-out')" :disabled="webBundyLoading">
                                                    <i class="ti-home btn-icon-prepend"></i>
                                                    Clock Out
                                                </button>
                                                <button type="button" x-show="breakOutBtn" class="btn btn-sm btn-primary btn-icon-text break-out text-white" style="border-radius: 5px;" @click="webBundyFunction({{ auth()->user()->id }}, 'break-out')" :disabled="webBundyLoading">
                                                    <i class="ti-bell btn-icon-prepend"></i>
                                                    Break Out
                                                </button>
                                                <button type="button" x-show="breakInBtn" class="btn btn-sm btn-primary btn-icon-text break-in text-white" style="border-radius: 5px;" @click="webBundyFunction({{ auth()->user()->id }}, 'break-in')" :disabled="webBundyLoading">
                                                    <i class="ti-pencil-alt btn-icon-prepend"></i>
                                                    Break In
                                                </button>
                                            </div>
                                        </template>
                                    </div>
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
            <div class="col-lg-6 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title card-title-dash">Leave Requests</h4>
                                        <p class="text-small modern-color-999">See all of your Leave Request here...</p>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary employee-btn mt-2" style="border-radius: 5px;" @click="createRequest">Request</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-sm table-responsive">
                                        <table class="table table-striped table-bordered">
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
                                                        <td class="text-center" colspan="5">
                                                            <div class="spinner-container">
                                                                <div class="spinner"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </template>
                                            <template x-if="!leaveIsLoading">
                                                <tbody>
                                                    <template x-if="(leaveData ?? []).length == 0">
                                                        <tr class="text-center">
                                                            <td class="" colspan="5"><i class="fa fa-info-circle"></i> There Leave Request's record.</td>
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
                                                                </td>
                                                                <td class="text-center" style="padding-top: 18px;">
                                                                    <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton12" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-lg fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton12">
                                                                        <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="editLeaveRequest(indexData)" >
                                                                            <template x-if="rows.status != 'Pending'">
                                                                                <i class="ti-eye btn-icon-prepend me-2"></i>
                                                                            </template>
                                                                            <template x-if="rows.status == 'Pending'">
                                                                                <i class="ti-pencil btn-icon-prepend me-2"></i>
                                                                            </template>
                                                                            <span x-text="rows.status != 'Pending' ? 'View' : 'Edit'"></span>
                                                                        </a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="removeLeaveRequest(indexData)" >
                                                                            <template x-if="rows.status != 'Pending'">
                                                                                <i class="ti-trash btn-icon-prepend me-2"></i>
                                                                            </template>
                                                                            <template x-if="rows.status == 'Pending'">
                                                                                <i class="ti-close btn-icon-prepend me-2"></i>
                                                                            </template>
                                                                            <span x-text="rows.status != 'Pending' ? 'Delete' : 'Cancel'"></span>
                                                                        </a>
                                                                    </div>
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
            <div class="col-lg-6 d-flex flex-column">
                <div class="row flex-grow">
                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="card-title card-title-dash">Attendance Monitoring</h4>
                                        <p class="text-small modern-color-999">Filter and search your attendance here...</p>
                                    </div>
                                    <div>
                                        <div class="input-group">
                                            <span class="icon-calendar input-group-text calendar-icon"></span>
                                            <input type="text" class="form-control bg-white text-center" id="attendance-monitoring-input" name="attendance-monitoring-input" x-model="dateToday" x-bind:value="dateToday" x-on:datetime-changed="dateToday = $event.target.value">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-sm table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Clock In</th>
                                            <th>Break Out</th>
                                            <th>Break In</th>
                                            <th>Clock Out</th>
                                        </tr>
                                        </thead>
                                        <template x-if="attendanceMonitoringLoading">
                                            <tbody>
                                                <tr class="text-center">
                                                    <td colspan="5">
                                                        <div class="spinner-container">
                                                            <div class="spinner"></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                        <template x-if="!attendanceMonitoringLoading">
                                            <tbody>
                                                <template x-if="(fetchAttendance ?? []).length == 0">
                                                    <tr class="text-center">
                                                        <td class="" colspan="5"><i class="fa fa-info-circle"></i> There is no attendance record for this date.</td>
                                                    </tr>
                                                </template>
                                                <template x-if="(fetchAttendance ?? []).length > 0">
                                                    <template x-for="(row, data) in fetchAttendance">
                                                        <tr class="text-center">
                                                            <td x-text="row.clock_in"></td>
                                                            <td x-text="row.break_out"></td>
                                                            <td x-text="row.break_in"></td>
                                                            <td x-text="row.clock_out"></td>
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
        @include('modals.leave-request-modal')
    @endif
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/dashboard.js') }}"></script>
@endpush
