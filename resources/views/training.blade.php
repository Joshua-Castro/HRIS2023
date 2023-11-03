@extends('layouts.main')

@section('content')
<div class="row" x-data="training()">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title card-title-dash">Training And Seminars</h4>
                        <p class="text-small modern-color-999">Manage your trainings and seminar schedule here...</p>
                    </div>
                    <form id="training-search-form" class="d-none">
                        <input type="hidden" name="training-title">
                        <input type="hidden" name="training-pagination-hidden">
                        <input type="hidden" name="page">
                    </form>
                    <div class="col-lg-6 d-flex justify-content-end">
                        <div class="input-group me-2" style="width: 270px;">
                            <input id="training-search-keyword" type="text" class="form-control form-control-sm" name="search-keyword" placeholder="Search title here ..." x-model="trainingSearchInput">
                            <div class="input-group-append">
                                <button id="training-search" class="btn input-group-text btn-secondary border waves-effect form-control form-control-sm text-dark" type="button" style="border-end-start-radius: 0px; border-start-start-radius: 0px;" @click="getTraining" :disabled="buttonDisabled">Search</button>
                            </div>
                        </div>
                        <div class="col-lg-2 me-2" style="padding-top: 1px;">
                            <select id="training-pagination" class="form-select form-select-sm bg-soft-secondary fw-bold" x-model="trainingPagination" @change="getTraining">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;" @click="createTraining">
                            Create
                        </button>
                    </div>
                </div>

                <div class="table-sm table-responsive mt-1">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <template x-if="trainingLoading">
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <div class="spinner-container">
                                            <div class="spinner"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                        <template x-if="!trainingLoading">
                            <tbody>
                                <template x-if="(trainingData ?? []).length == 0">
                                    <tr class="text-center">
                                        <td class="" colspan="7"><i class="fa fa-info-circle"></i> There is no training's record.</td>
                                    </tr>
                                </template>
                                <template x-if="(trainingData ?? []).length > 0">
                                    <template x-for="(rows, index) in trainingData">
                                        <tr>
                                            <td class="pb-1 pt-2"> {{-- TO MAKE THE TABLE MORE COMPRESSED ADD CLASS IN THIS <td> 'class="pb-1 pt-2"' --}}
                                                <div class="d-flex align-items-center mt-0 mb-0 pt-0 pb-0">
                                                    <div class="ms-2">
                                                        <p class="dark-text fs-14 fw-bold mb-0 pb-0" x-text="rows.title">Sample Training Title</p>
                                                        <p class="text-muted text-small">Department that will have the training</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td x-text="rows.description" style="white-space: pre-wrap; line-height: 1.5;"></td>
                                            <td x-text="rows.location"></td>
                                            <td x-text="moment(rows.start_date_time).format('YYYY-MM-DD / dddd').toUpperCase()"></td>
                                            <td x-text="moment(rows.end_date_time).format('YYYY-MM-DD / dddd').toUpperCase()"></td>
                                            <td x-text="rows.duration"></td>
                                            <td class="text-center" style="padding-top: 18px;">
                                                <a href="javascript:void(0);" class="text-reset text-decoration-none" id="dropdownMenuSplitButton14" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-lg fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton14">
                                                    <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="editTraining(index, 'view')">
                                                        <i class="ti-eye btn-icon-prepend me-2"></i>
                                                        View
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item align-items-center text-reset text-decoration-none" href="javascript:void(0);" @click="editTraining(index, 'edit')">
                                                        <i class="ti-pencil btn-icon-prepend me-2"></i>
                                                        Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-reset text-decoration-none" href="javascript:void(0);" @click="removeTraining(index)">
                                                        <i class="ti-trash btn-icon-prepend me-2"></i>
                                                        Delete
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
                            <p id="training-counter" class="m-0">No trainings to display</p>
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
    @include('modals.training-modal')
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/training.js') }}"></script>
@endpush
