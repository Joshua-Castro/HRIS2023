@extends('layouts.main')

@section('content')
<div class="row" x-data="attendance()">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-rounded">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">Attendance Monitoring</h4>
                        <p class="text-small modern-color-999">Monitor your employees attendance here...</p>
                    </div>
                    <div>
                        <div class="row gx-1">
                            <form id="attendance-search-form" class="d-none">
                                <input type="hidden" name="employee-number-hidden" x-ref="employeeNumberInput">
                                <input type="hidden" name="attendance-pagination-hidden">
                                <input type="hidden" name="page">
                                <input type="hidden" name="date-from">
                                <input type="hidden" name="date-to">
                            </form>
                            <div class="col-lg-7 col-sm-12">
                                <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold" type="button" style="border-radius: 5px;" @click="filtering">
                                    <i class="ti ti-sm ti-filter me-2" style="font-size: 14px;"></i>
                                    Filter
                                </button>
                            </div>
                            <div class="col-lg-5 col-sm-12">
                                <select id="attendance-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="currentPagination" @change="getAllAttendance">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="row gx-1">
                            <form id="attendance-search-form" class="d-none">
                                <input type="hidden" name="employee-number-hidden" x-ref="employeeNumberInput">
                                <input type="hidden" name="attendance-pagination-hidden">
                                <input type="hidden" name="attendance-page-hidden">
                            </form>
                            <div class="col-md-8 mb-2 mb-lg-0">
                                <div class="input-group">
                                    <input id="attendance-search-keyword" type="text" class="form-control form-control-sm"
                                        name="search-keyword" placeholder="Name" x-model="currentSearchName" @keydown="inputAttendanceSearch">
                                    <div class="input-group-append">
                                        <button id="attendance-search"
                                        class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark"
                                        type="button" x-ref="attendanceSearchButton" @click="getAllAttendance" style="border-end-start-radius: 0px; border-start-start-radius: 0px;">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 1px;">
                                <select id="attendance-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="currentPagination" @change="getAllAttendance">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Date / Day</th>
                                <th>Clock In</th>
                                <th>Break Out</th>
                                <th>Break In</th>
                                <th>Clock Out</th>
                                {{-- <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <template x-if="attendanceLoading">
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="10"><div class="spinner-border"></div></td>
                                </tr>
                            </tbody>
                        </template>
                        <template x-if="!attendanceLoading">
                            <tbody>
                                <template x-if="(attendanceData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="7"><i class="fa fa-info-circle"></i> There is no attendance record.</td>
                                    </tr>
                                </template>
                                <template x-if="(attendanceData ?? []).length > 0">
                                    <template x-for="(rows, indexData) in attendanceData">
                                        <tr>
                                            <td class="pb-1 pt-2"> {{-- TO MAKE THE TABLE MORE COMPRESSED ADD CLASS IN THIS <td> 'class="pb-1 pt-2"' --}}
                                                <div class="d-flex align-items-center mt-0 mb-0 pt-0 pb-0">
                                                    <div class="ms-2">
                                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0" x-text="rows.first_name + ' ' + (rows.middle_name ?? '') + ' ' + rows.last_name"></p>
                                                        <p class="text-muted text-small" x-text="rows.position"></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td x-text="moment(rows.created_at).format('YYYY-MM-DD / dddd').toUpperCase()"></td>
                                            <td x-text="rows.clock_in"></td>
                                            <td x-text="rows.break_out"></td>
                                            <td x-text="rows.break_in"></td>
                                            <td x-text="rows.clock_out"></td>
                                            {{-- <td class="text-center">SAMPLE</td> --}}
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                        </template>
                    </table>
                    <div class="row gx-0">
                        <div class="col-md-6 mb-2 my-md-auto">
                            <p id="attendance-counter" class="m-0">No attendance to display</p>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination pagination-rounded float-md-end mt-2 mb-0">
                                    {{-- PAGINATION --}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.attendance-filter-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/attendance.js') }}"></script>
@endpush
