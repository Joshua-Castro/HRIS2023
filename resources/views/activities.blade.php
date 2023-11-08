@extends('layouts.main')

@section('content')
<div class="row" x-data="activity()">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <template x-if="!logsLoading">
                    <div class="d-flex align-items-center justify-content-start mb-3">
                        <h4 class="card-title card-title-dash">Activities</h4>
                    </div>
                </template>
                <template x-if="logsLoading">
                        <div class="spinner-container mb-4">
                            <div class="spinner"></div>
                        </div>
                </template>
                <div style="max-height: 250px; overflow-y: auto;">
                    <ul class="bullet-line-list">
                        <template x-for="(rows, index) in logsData">
                            <li class="mb-2">
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
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('template/pages-js/activity.js') }}"></script>
@endpush
