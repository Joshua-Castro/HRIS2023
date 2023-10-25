@extends('layouts.main')

@section('content')
<div class="row" x-data="profile({{ $userId }})">
    <div class="col-lg-5 d-flex flex-column">
        <div class="row flex-grow">
            <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <template x-if="profileLoading">
                            <div class="spinner-container">
                                <div class="spinner"></div>
                            </div>
                        </template>
                        <template x-if="!profileLoading">
                            <div>
                                <div class="row justify-content-center">
                                    <img src="{{ asset($image) }}" alt="profile" class="rounded-circle mb-3" style="width: 210px; height: 170px;">
                                    <span class="text-center" style="font-size: 28px; font-weight: 900;" x-text="fullName"></span>
                                    <span class="text-center" style="font-size: 16px; font-weight: inherit; color:rgb(177, 177, 177)" x-text="profileData.employee_no"></span>
                                    <hr class="mt-4" style="width: 90%;">
                                </div>
                                <h6 class="header-title mb-4 ms-3 fw-bold text-center">GOVERNMENT INFORMATION</h6>
                                <div class="row justify-content-between">
                                    <div class="col-lg-4">
                                        <div class="col-lg-12 mt-1">
                                            <span class="ms-4" style="font-size: 16px; font-weight: inherit;">GSIS NUMBER </span>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <span class="ms-4" style="font-size: 16px; font-weight: inherit;">PHILHEALTH NUMBER </span>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <span class="ms-4" style="font-size: 16px; font-weight: inherit;">PAGIBIG NUMBER </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-center">
                                        <div class="col-lg-12 mt-1">
                                            <span style="font-size: 16px; font-weight: 900;">: </span>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <span style="font-size: 16px; font-weight: 900;">: </span>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <span style="font-size: 16px; font-weight: 900;">: </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-lg-12 mt-1" style="margin-left: -25px;">
                                            <span style="font-size: 16px; font-weight: inherit;" x-text="profileData.gsis"></span>
                                        </div>
                                        <div class="col-lg-12 mt-1" style="margin-left: -25px;">
                                            <span style="font-size: 16px; font-weight: inherit;" x-text="profileData.phil_health"></span>
                                        </div>
                                        <div class="col-lg-12 mt-1" style="margin-left: -25px;">
                                            <span style="font-size: 16px; font-weight: inherit;" x-text="profileData.pag_ibig"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-flex flex-column">
        <div class="row flex-grow">
        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body ">
                    <template x-if="profileLoading">
                        <div class="spinner-container">
                            <div class="spinner"></div>
                        </div>
                    </template>
                    <template x-if="!profileLoading">
                        <div>
                            <h6 class="card-title card-title-dash text-dark mb-4 text-center">GENERAL INFORMATION</h6>
                            <div class="row justify-content-between">
                                <div class="col-lg-4">
                                    <div class="col-lg-12 mt-1">
                                        <span class="ms-4" style="font-size: 16px; font-weight: inherit;">POSITION </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="ms-4" style="font-size: 16px; font-weight: inherit;">LAST PROMOTION </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="ms-4" style="font-size: 16px; font-weight: inherit;">DATE HIRED </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="ms-4" style="font-size: 16px; font-weight: inherit;">STATION CODE </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="ms-4" style="font-size: 16px; font-weight: inherit;">CONTROL NUMBER </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="col-lg-12 mt-1">
                                        <span style="font-size: 16px; font-weight: 900;">: </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span style="font-size: 16px; font-weight: 900;">: </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span style="font-size: 16px; font-weight: 900;">: </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span style="font-size: 16px; font-weight: 900;">: </span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span style="font-size: 16px; font-weight: 900;">: </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-end">
                                    <div class="col-lg-12 mt-1">
                                        <span class="me-4" style="font-size: 16px; font-weight: inherit;" x-text="profileData.position"></span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="me-4" style="font-size: 16px; font-weight: inherit;" x-text="moment(profileData.last_promotion).format('YYYY-MM-DD').toUpperCase()"></span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="me-4" style="font-size: 16px; font-weight: inherit;" x-text="moment(profileData.date_hired).format('YYYY-MM-DD').toUpperCase()"></span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="me-4" style="font-size: 16px; font-weight: inherit;" x-text="profileData.station_code"></span>
                                    </div>
                                    <div class="col-lg-12 mt-1">
                                        <span class="me-4" style="font-size: 16px; font-weight: inherit;" x-text="profileData.control_no"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <template x-if="profileLoading">
                        <div class="spinner-container">
                            <div class="spinner"></div>
                        </div>
                    </template>
                    <template x-if="!profileLoading">
                        <div>
                            <h6 class="card-title card-title-dash text-dark mb-4 text-center">ACCOUNT INFORMATION</h6>
                            <div class="row mt-1 mb-4 g-0">
                                <div class="col-12 col-md-6">
                                    <div class="form-group row p-1 m-0">
                                        <div class="col-sm-12 p-0 m-0">
                                            <div class="form-floating">
                                                <input type="text" name="email" class="form-control " placeholder="Username" autocomplete="email" x-model="userEmail">
                                                <label for="email">Username</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group row p-1 m-0">
                                        <div class="col-sm-12 p-0 m-0">
                                            <div class="d-flex flex-row form-floating position-relative">
                                                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" x-model="userPassword">
                                                <label for="password">Password</label>
                                                <button type="button" class="btn btn-light eye-icon"><i class="fa fa-eye-slash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/profile.js') }}"></script>
@endpush
