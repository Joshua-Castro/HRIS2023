
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>HRIS </title>
  {{-- <link rel="stylesheet" href="{{ asset('template/vendors/feather/feather.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('template/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/ti-icons/css/themify-icons.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('template/vendors/typicons/typicons.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('template/vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('template/vendors/font-awesome/css/font-awesome.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">
  {{-- <link rel="shortcut icon" href="{{ asset('template/images/auth/deped-logo.jpg') }}" /> --}}
  <link rel="stylesheet" href="{{ asset('template/vendors/fullcalendar/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/css/select2.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/select2-bootstrap-5-theme.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/select2-bootstrap-5-theme.rtl.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/slick.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/filepond.css') }}" />
  <link rel="stylesheet" href="{{ asset('template/css/custom-styles.css') }}" />
  <script src="{{ asset('template/js/pace.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('template/css/minimal.css') }}" />

  @stack('styles')
  <script defer src="{{ asset('template/js/alpinejs@3.min.js') }}"></script>
  @routes
</head>
<body class="with-welcome-text">
    <div class="container-scroller">
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start bg-white">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                {{-- <a class="navbar-brand brand-logo" href="/index.html">
                <img src="{{ asset('template/images/logo.svg') }}" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="/index.html">
                <img src="{{ asset('template/images/logo-mini.svg') }}" alt="logo" />
                </a> --}}
                <h4 class="mt-2 navbar-brand brand-logo">HRIS</h4>
            </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
                <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Good Day, <span class="text-black fw-bold">{{ Auth::user()->name ?? Auth::user()->email }}</span></h1>
                @if(auth()->user()->is_admin == 1)
                <h3 class="welcome-sub-text">All details about your employees are here... </h3>
                @else
                <h3 class="welcome-sub-text">All details about your work benefits are here... </h3>
                @endif
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-none d-lg-block">
                <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                    <span class="input-group-addon input-group-prepend border-right">
                        <span class="icon-calendar input-group-text calendar-icon"></span>
                    </span>
                    <input type="text" class="form-control">
                </div>
                </li>
                <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="{{ asset($image) }}" alt="Profile image" style="width: 40px; height: 40px;"> </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-xs rounded-circle" src="{{ asset($image) }}" alt="Profile image" style="width: 40px; height: 40px;">
                            <p class="mb-0 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                            <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                        </div>
                        <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="dropdown-item-icon ti ti-user text-primary me-3" style="font-size: 18px;"></i> Profile</a>
                        <a class="dropdown-item"><i class="dropdown-item-icon ti ti-pencil-alt text-primary me-3" style="font-size: 18px;"></i> Activity</a>
                        <a class="dropdown-item"><i class="dropdown-item-icon ti ti-help text-primary me-3" style="font-size: 18px;"></i> FAQ</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="dropdown-item-icon ti ti-share-alt text-primary me-3" style="font-size: 18px;"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas bg-white" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="ti ti-dashboard ms-3 me-4" style="font-size: 20px;"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    @if (auth()->user()->is_admin == 1)
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#requests" aria-expanded="false" aria-controls="requests">
                                <i class="ti ti-agenda ms-3 me-4" style="font-size: 20px;"></i>
                                <span class="menu-title">Requests</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                        <div class="collapse" id="requests">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item ms-4"> <a class="nav-link" href="{{ route('request') }}">Leave</a></li>
                            </ul>
                        </div>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attendance') }}">
                                <i class="ti ti-alarm-clock ms-3 me-4" style="font-size: 20px;"></i>
                                <span class="menu-title">Attendance</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('training') }}">
                                <i class="ti ti-briefcase ms-3 me-4" style="font-size: 20px;"></i>
                                <span class="menu-title">Trainings</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                            <i class="ti ti-settings ms-3 me-4" style="font-size: 20px;"></i>
                            <span class="menu-title">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                    </li>
                    <div class="collapse" id="settings">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item ms-4"> <a class="nav-link" href="{{ route('profile.index') }}">Profile</a></li>
                            <li class="nav-item ms-4"> <a class="nav-link" href="javascript:void(0);">Activity</a></li>
                            <li class="nav-item ms-4"> <a class="nav-link" href="javascript:void(0);">FAQ</a></li>
                            <li class="nav-item ms-4"> <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </div>
                </ul>
            </nav>
            <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Human Resource Information System <a href="{{ route('home') }}" target="_blank">(HRIS)</a></span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. All rights reserved.</span>
                </div>
            </footer>
            </div>
        </div>
    </div>

  <script src="{{ asset('template/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('template/vendors/moment/moment.js') }}"></script>
  <script src="{{ asset('template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('template/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <script src="{{ asset('template/js/off-canvas.js') }}"></script>
  <script src="{{ asset('template/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('template/js/template.js') }}"></script>
  <script src="{{ asset('template/js/settings.js') }}"></script>
  <script src="{{ asset('template/js/todolist.js') }}"></script>
  <script src="{{ asset('template/js/jquery.cookie.js') }}" type="text/javascript"></script>
  <script src="{{ asset('template/vendors/bootstrap-datetimepicker/datetimepicker.min.js') }}"></script>
  <script src="{{ asset('template/js/dashboard.js') }}"></script>
  <script src="{{ asset('template/js/select2.min.js') }}"></script>
  <script src="{{ asset('template/js/slick.min.js') }}"></script>
  <script src="{{ asset('template/vendors/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('template/js/Chart.roundedBarCharts.js') }}"></script>
  <script src="{{ asset('template/vendors/fullcalendar/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('template/js/filepond.js') }}"></script>
  <script src="{{ asset('template/vendors/inputmask/jquery.inputmask.bundle.js') }}"></script>
  <script src="{{ asset('template/js/inputmask.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('scripts')
</body>
</html>

