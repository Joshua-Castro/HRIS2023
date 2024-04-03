@extends('layouts.main')

@section('content')
<div class="row" x-data="attendance()">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-style-border">
            <div class="card-body">
                <div class="row">
                    <form id="attendance-search-form" class="d-none">
                        <input type="hidden" name="employee-number-hidden" x-ref="employeeNumberInput">
                        <input type="hidden" name="attendance-pagination-hidden">
                        <input type="hidden" name="page">
                        <input type="hidden" name="date-from">
                        <input type="hidden" name="date-to">
                    </form>
                    <div class="col-md-6">
                        <h4 class="card-title card-title-dash">Attendance Monitoring</h4>
                            <p class="text-small modern-color-999">Monitor your employees attendance here...</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;" @click="filtering">
                            <i class="ti ti-sm ti-filter me-2" style="font-size: 14px;"></i>
                            Filter
                        </button>
                        <select id="attendance-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="currentPagination" style="border-radius: 5px; width: 80px; height: 31.6px;" @change="getAllAttendance">
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
                                <th>Date / Day</th>
                                <th>Clock In</th>
                                <th>Break Out</th>
                                <th>Break In</th>
                                <th>Clock Out</th>
                                <th class="text-center">Notes</th>
                                <th class="text-center">Action</th>
                                {{-- <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <template x-if="attendanceLoading">
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
                        <template x-if="!attendanceLoading">
                            <tbody>
                                <template x-if="(attendanceData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="8"><i class="fa fa-info-circle"></i> There is no attendance record.</td>
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
                                            <td x-text="moment(rows.attendance_date).format('YYYY-MM-DD / dddd').toUpperCase()"></td>
                                            <td x-text="rows.clock_in"></td>
                                            <td x-text="rows.break_out"></td>
                                            <td x-text="rows.break_in"></td>
                                            <td x-text="rows.clock_out"></td>
                                            <td class="text-center py-0 text-wrap" x-text="(rows.notes ?? '-')"></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-lg fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                                                    <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="editEmployeeAttendance(indexData)">
                                                        <i class="ti-pencil btn-icon-prepend me-2"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);">
                                                        <i class="ti-eye btn-icon-prepend me-2"></i>
                                                        View
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
                            <p id="attendance-counter" class="m-0">No attendance to display</p>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination pagination-sm float-md-end mt-2 mb-0">
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
    @include('modals.edit-attendance-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/attendance.js') }}"></script>
@endpush
