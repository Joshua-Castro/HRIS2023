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
                </div>
                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Employee Number</th>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Break Out</th>
                                <th>Break In</th>
                                <th>Clock Out</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td>SAMPLE</td>
                                <td class="text-center">SAMPLE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/attendance.js') }}"></script>
@endpush
