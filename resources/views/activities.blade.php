@extends('layouts.main')

@section('content')
<div class="row" x-data="activity()">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <template x-if="!logsLoading">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title card-title-dash">Activities / Logs</h4>
                            <p class="text-small modern-color-999">See all of the users actions / logs here...</p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary form-control form-control-sm btn-icon fw-bold me-1" type="button" style="border-radius: 5px; width: 150px;" @click="fetchLogs">
                                <i class="ti ti-reload me-2" style="font-size: 14px;"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </template>
                <template x-if="logsLoading">
                        <div class="spinner-container mb-4">
                            <div class="spinner"></div>
                        </div>
                </template>
                <template x-if="!logsLoading">
                    <template x-if="(logsData ?? []).length == 0">
                        <div class="row justify-content-center">
                            <span class="text-center fw-bold text-uppercase">There is no actions / logs taken yet..</span>
                        </div>
                    </template>
                </template>
                <template x-if="!logsLoading">
                    <div style="max-height: 250px; overflow-y: auto;">
                        <ul class="bullet-line-list">
                            <template x-for="(rows, index) in logsData">
                                <li class="my-2">
                                    <div class="d-flex justify-content-between me-4">
                                        <div>
                                            <img class="img-xs rounded-circle me-2" x-bind:src="rows.image_filepath ? 'storage/' + rows.image_filepath : 'template/images/default-icon.png'" alt="Profile image" style="width: 25px; height: 25px;"> </a>
                                            <span class="text-light-green fw-bold" x-text="rows.creator_name"></span>
                                            <span x-text="rows.description"></span>
                                        </div>
                                        <p x-text="rows.created_at"></p>
                                    </div>
                                </li>
                            </template>
                        </ul>
                        <div class="list align-items-center pt-3">
                            <div class="wrapper w-100">
                            {{-- <p class="mb-0">
                                <a href="#" class="fw-bold text-primary text-decoration-none">Show all <i class="ti-arrow-right ms-2"></i></a>
                            </p> --}}
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/activity.js') }}"></script>
@endpush
