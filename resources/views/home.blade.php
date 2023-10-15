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
<div class="row" x-data="adminDashboard()">
    <div class="col-sm-12">
      <div class="home-tab">
        @if(auth()->user()->is_admin == 1)
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
        @endif
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
    @include('modals.leave-request-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/dashboard.js') }}"></script>
@endpush
