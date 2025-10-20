<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
    <meta name="keywords"
        content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Login - SPI Navigator</title>
    <link rel="apple-touch-icon"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/icons/Logo-Persero-Batam.jpg') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700"
        rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/vendors/css/forms/icheck/custom.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/css/app.css') }}">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/css/pages/login-register.css') }}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/assets/css/style.css') }}">
    <!-- END Custom CSS-->
</head>
<style>
    body {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
        overflow: hidden;
        position: relative;
    }

    .background-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1s ease-in-out, transform 1s ease-in-out;
        transform: translateX(100%);
        z-index: 1;
    }

    .background-slide.active {
        opacity: 1;
        transform: translateX(0);
    }

    .background-slide.next {
        transform: translateX(-100%);
    }

    .app-content {
        position: relative;
        z-index: 2;
    }
</style>


<body class="vertical-layout vertical-menu 1-column bg-white bg-lighten-2 menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="1-column">

    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-shadow"
        style="background: navy">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                            data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container">
                <div class="collapse navbar-collapse justify-content-end" id="navbar-mobile">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a class="nav-link mr-2 nav-link-label" href="/"><i
                                    class="ficon ft-arrow-left"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <img src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/icons/Logo-Persero-Batam.png') }}"
                                            alt="perserobatam logo">
                                    </div>
                                    <h3 class="card-subtitle text-center text-bold pt-2" style="color: navy">Welcome to
                                        SPI Navigator!</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form class="form-horizontal" action="{{ route('login') }}" method="POST"
                                            novalidate>
                                            @csrf
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="email" class="form-control input-lg" id="email"
                                                    name="email" placeholder="Email" tabindex="1" required
                                                    data-validation-required-message="Please enter your email.">
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control input-lg" id="password"
                                                    name="password" placeholder="Password" tabindex="2" required
                                                    data-validation-required-message="Please enter your password.">
                                                <div class="form-control-position">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                                <div class="help-block font-small-3"></div>
                                            </fieldset>
                                            <button type="submit"
                                                class="btn btn-primary btn-block btn-lg">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script
        src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/vendors/js/vendors.min.js') }}">
    </script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script
        src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}">
    </script>
    <script
        src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/vendors/js/forms/icheck/icheck.min.js') }}">
    </script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script
        src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/js/core/app-menu.js') }}">
    </script>
    <script src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/js/core/app.js') }}">
    </script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script
        src="{{ asset('../Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/js/scripts/forms/form-login-register.js') }}">
    </script>
    <!-- END PAGE LEVEL JS-->
    <script>
        var images = [
            "{{ asset('Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/pictures/1.jpg') }}",
            "{{ asset('Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/pictures/2.jpg') }}",
            "{{ asset('Robust-responsive-bootstrap-4-admin-template-build-system/app-assets/images/pictures/3.jpg') }}"
        ];

        var currentImageIndex = 0;

        function changeBackground() {
            var currentSlide = document.querySelector('.background-slide.active');
            var nextSlide = document.createElement('div');
            nextSlide.className = 'background-slide';
            nextSlide.style.backgroundImage = 'url(' + images[currentImageIndex] + ')';

            document.body.appendChild(nextSlide);

            setTimeout(function() {
                nextSlide.classList.add('active');
            }, 10);

            setTimeout(function() {
                if (currentSlide) {
                    currentSlide.classList.remove('active');
                    currentSlide.classList.add('next');
                    setTimeout(function() {
                        document.body.removeChild(currentSlide);
                    }, 1000);
                }
            }, 1000);

            currentImageIndex = (currentImageIndex + 1) % images.length;
        }

        setInterval(changeBackground, 2500);
        changeBackground();
    </script>
</body>

</html>
