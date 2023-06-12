@extends('layouts.app')

@section('content')
<style>
    .carousel-item {
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    }

    .authentication-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        margin: 0 10px;
        border: 0;
        border-radius: 50%;
    }

    .carousel-indicators .active {
        width: 50px;
        border-radius: 10px;
    }
</style>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <div class="account-pages vh-100">
        <div class="container authentication-container">
            <div class="card shadow-lg overflow-hidden m-0">
                <div class="card-body p-0">
                    <div class="row">
                        {{-- Login Form --}}
                        <div class="col-12 col-md-6 col-lg-4 px-4 pe-md-3 pt-3 pb-5 position-relative">
                            <div class="flex-row brand-logo-mini d-flex justify-content-center">
                                <a href="{{ route('login') }}">
                                    <img src="{{ asset("template/images/auth/deped-logo.jpg") }}" alt="logo" height="100">
                                </a>
                            </div>

                            <h3 class="text-dark mt-4 mb-1 px-2">Welcome!</h3>
                            <p class="text-muted w-75 mb-4 px-2">Please log in to discover your employee status and leverage the HRIS system's functionalities.</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                @if (session('error'))
                                    <div class="mb-2 px-2">
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                {{-- email --}}
                                <div class="mb-2 px-2">
                                    <label for="email" class="form-label">Email address</label>
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required>

                                    @error('email')
                                        <ul class="invalid-feedback ps-3" role="alert">
                                            <li><strong>{{ $message }}</strong></li>
                                        </ul>
                                    @enderror
                                </div>

                                {{-- password --}}
                                <div class="mb-2 px-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" required>

                                    @error('password')
                                        <ul class="invalid-feedback ps-3" role="alert">
                                            <li><strong>{{ $message }}</strong></li>
                                        </ul>
                                    @enderror
                                </div>

                                {{-- login button --}}
                                <div class="text-center d-grid px-2 py-3">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>

                            <div class="mt-2 mb-4 text-center">
                                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-theme text-decoration-underline ms-1"><b>Register</b></a></p>
                            </div>
                            <!-- end row -->
                        </div> <!-- end col -->

                        <div class="features d-none d-md-block col-md-6 col-lg-8 p-0">
                            <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner h-100">
                                    <div class="carousel-item h-100 active" style="background-image: url({{ asset("template/images/auth/deped1.jpg") }})">
                                        
                                    </div>
                                    <div class="carousel-item h-100" style="background-image: url({{ asset("template/images/auth/deped2.jpg") }})">
                                        {{-- <div class="h-100 pt-3">
                                            <div class="feature-container">
                                                <p class="feature-title">Keep track of your progress. Anytime. Anywhere.</p>
                                                <p class="feature-description">Making progress every day is one way toward achieving your goal. <strong>eiMAN</strong> can help you achieve those goals by providing accessible options, lists, and displays of your task's activities and updates. Monitor your tasks and progress anytime, anywhere!</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="carousel-item h-100" style="background-image: url({{ asset("template/images/auth/deped3.jpg") }})">
                                        {{-- <div class="h-100 pt-3">
                                            <div class="feature-container">
                                                <p class="feature-title">Collaborate with your team.</p>
                                                <p class="feature-description">Do more by teaming with your friends or colleagues. <strong>eiMAN</strong> allows you to collaborate with anyone you want to achieve common goals. Plan, coordinate, organize, control, and track your team's tasks. Create memories and achieve great things with your team and us.</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection
