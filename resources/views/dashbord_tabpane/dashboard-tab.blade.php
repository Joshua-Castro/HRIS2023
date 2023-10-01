@if(auth()->user()->is_admin == 1)
<div class="row">
    <div class="col-sm-12">
        <div class="statistics-details mb-0">
            <div class="row details-count">
                <div class="mx-2 py-4">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <p class="card-title card-title-dash font-weight-medium">Total employees</p>
                                <h3 class="rate-percentage d-flex justify-content-between" x-text="employeeCount"></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-2 py-4">
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
                <div class="mx-2 py-4">
                    <div class="card">
                    <div class="card-body">
                        <div>
                        <p class="card-title card-title-dash font-weight-medium">New employees</p>
                        <h3 class="rate-percentage d-flex justify-content-between">SOON</h3>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="mx-2 py-4">
                    <div class="card">
                    <div class="card-body">
                        <div>
                        <p class="card-title card-title-dash font-weight-medium">Overtime Requests</p>
                        <h3 class="rate-percentage  d-flex justify-content-between">SOON</h3>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="mx-2 py-4">
                    <div class="card">
                    <div class="card-body">
                        <div>
                        <p class="card-title card-title-dash font-weight-medium">Others</p>
                        <h3 class="rate-percentage d-flex justify-content-between">SOON</h3>
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
                <div class="card" style="height: 460px;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="margin-top: -100px;">
                        <h3 class="card-title card-title-dash text-center">Employee Overview</h3>
                        <p class="text-small modern-color-999 text-center">Information about your People</p>
                        <div id="customerOverviewEcommerce-legend" class="text-center mb-2 rectangle-legend"></div>
                        <div class="chartjs-wrapper doughnut-height-ecommerce mt-2 position-relative text-center">
                            <canvas class="my-auto" id="customerOverviewEcommerce" style="height: 250px; width: 250px;"></canvas>
                            <div class="chartjs-inner-text" style="margin-top: -150px">
                                <h4 x-text="employeeCount"></h4>
                                <p>Total Employee</p>
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
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <template x-if="timeLoading">
                                        <div class="spinner-border"></div>
                                    </template>
                                    <h3 class="rate-percentage text-primary" style="font-size: 24px;" x-text="currentTime"></h3>
                                </div>
                                <template x-if="!timeLoading">
                                    <div class="col-lg-6 col-md-12 d-flex justify-content-end">
                                        <button type="button" x-show="clockInBtn" class="btn btn-primary btn-icon-text clock-in text-white" @click="webBundyFunction({{ auth()->user()->id }}, 'clock-in')">
                                            <i class="ti-alarm-clock btn-icon-prepend"></i>
                                            Clock In
                                        </button>
                                        <button type="button" x-show="clockOutBtn" class="btn btn-primary btn-icon-text clock-out text-white" @click="webBundyFunction({{ auth()->user()->id }}, 'clock-out')">
                                            <i class="ti-home btn-icon-prepend"></i>
                                            Clock Out
                                        </button>
                                        <button type="button" x-show="breakOutBtn" class="btn btn-primary btn-icon-text break-out text-white" @click="webBundyFunction({{ auth()->user()->id }}, 'break-out')">
                                            <i class="ti-bell btn-icon-prepend"></i>
                                            Break Out
                                        </button>
                                        <button type="button" x-show="breakInBtn" class="btn btn-primary btn-icon-text break-in text-white" @click="webBundyFunction({{ auth()->user()->id }}, 'break-in')">
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
                        {{-- <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="modern-user-intro">Hello John Doe,</h4>
                                <h6 class="mdern-welcome-text">Welcome back</h6>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="align-items-start">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title card-title-dash">Leave Requests</h4>
                                    <button class="btn btn-outline-primary employee-btn" @click="createRequest">Request</button>
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
                                                            {{-- <p class="dark-text fs-14" ></p> --}}
                                                        </td>
                                                        <td class="text-center" style="padding-top: 28px;">
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-info" @click="editLeaveRequest(indexData)" :title="rows.status != 'Pending' ? 'View' : 'Edit'" x-text="rows.status != 'Pending' ? 'View' : 'Edit'"></button>
                                                            <button type="button" class="btn btn-sm action-btn btn-outline-danger" @click="removeLeaveRequest(indexData)" x-text="rows.status != 'Pending' ? 'Delete' : 'Cancel'"></button>
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
                                    {{-- <span x-text="dateToday"></span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="table-sm table-responsive ">
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
                                                <div class="spinner-border"></div>
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
@endif
