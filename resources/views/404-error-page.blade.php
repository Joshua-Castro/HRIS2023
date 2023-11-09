
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>HRIS </title>
<link rel="stylesheet" href="{{ asset('template/css/vertical-layout-light/style.css') }}">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center text-center error-page" style="background-image: url({{ asset('template/images/auth/error-page.jpg') }}); background-size: cover;">
                <div class="row flex-grow" style="background-color: rgba(255, 255, 255, 0.5); /* 50% white background color with 50% opacity */">
                    <div class="col-lg-7 mx-auto text-white">
                        <div class="row align-items-center d-flex flex-row">
                            <div class="col-lg-6 text-lg-right pr-lg-4">
                                <h1 class="display-1 mb-0 fw-bold" style="color: navy;">404</h1>
                            </div>
                            <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                                <h2 class="text-uppercase" style="color: navy;">PAGE NOT FOUND!</h2>
                                <h3 class="fw-light text-uppercase" style="color: navy;">{{ $message }}</h3>
                            </div>
                        </div>
                        <div class="row mt-3 mb-5">
                            <div class="col-12 text-center mt-xl-2">
                                <a class="fw-bold text-uppercase" href="{{ route('home') }}" style="color: navy;">Back to home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
