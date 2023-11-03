@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-start mb-3">
                    <h4 class="card-title card-title-dash">Activities</h4>
                </div>
                <div style="max-height: 250px; overflow-y: auto;">
                    <ul class="bullet-line-list">
                        <li>
                            <div class="d-flex justify-content-between me-4">
                                <div>
                                    <img class="img-xs rounded-circle me-2" src="{{ asset($image) }}" alt="Profile image" style="width: 25px; height: 25px;"> </a>
                                    <span class="text-light-green fw-bold">Ben Tossell</span> requested a leave : <span class="fw-bold">"Leave Type" </span> .
                                </div>
                                <p>Just now</p>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex justify-content-between me-4">
                                <div>
                                    <img class="img-xs rounded-circle me-2" src="{{ asset($image) }}" alt="Profile image" style="width: 25px; height: 25px;"> </a>
                                    <span class="text-light-green fw-bold">Ben Tossell</span> created a employee : <span class="fw-bold">"Employee Number" </span> .
                                </div>
                                <p>Just now</p>
                            </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Oliver Noah</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Jack William</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Leo Lucas</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Thomas Henry</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Ben Tossell</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
                        <li>
                        <div class="d-flex justify-content-between me-4">
                            <div><span class="text-light-green">Ben Tossell</span> assign you a task</div>
                            <p>1h</p>
                        </div>
                        </li>
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
    {{-- <script src="{{ asset('template/pages-js/training.js') }}"></script> --}}
@endpush
