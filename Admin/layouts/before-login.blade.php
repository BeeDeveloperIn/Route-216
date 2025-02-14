<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <title><?php bloginfo('title'); ?></title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ $adminAssets }}css/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ $adminAssets }}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ $adminAssets }}css/login-1.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="<?php echo asset('/'); ?>favicon.ico">
</head>
<!--end::Head-->
<!--begin::Body-->


<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
    <div class="" style="float: left;width: 100%;border-bottom: 2px solid #0c2a74;position: relative;text-align: center;padding: 10px;background-color: #fff;display: ruby;">
        <a href="/welcome" style="color: #3f4254;text-align: center;font-size: 14px;padding: 20px 20px;">Home</a>
        <a href="/support" style="color: #3f4254;text-align: center;font-size: 14px;padding: 20px 20px;">Support</a>
        <a href="/privacypolicy" style="color: #3f4254;text-align: center;font-size: 14px;padding: 20px 20px;">Privacy Policy & Copyright</a>
        <a href="/admin/login" style="color: #3f4254;text-align: center;font-size: 14px;padding: 20px 20px;">Admin Login</a>

        <div class="app-icons">
            <a href="https://apps.apple.com/in/app/route216/id6503343397" target="_blank">
                <img style="width: 125px;" class="apple" src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=250x83&amp;releaseDate=1276560000&h=7e7b68fad19738b5649a1bfb78ff46e9" alt="Download on the App Store - Route216" />
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.route216" target="_blank">
                <img style="width: 150px;" class="android" alt='Get it on Google Play - Route216' src='https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png' />
            </a>
        </div>
        @if (Session::has('success_message'))
            <div class="container" onclick="$(this).hide()">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success mb-10 p-5" role="alert">
                            <h4 class="alert-heading">Success!</h4>
                            <p>{{ Session::get('success_message') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Session::has('error_message'))
            <div class="container" onclick="$(this).hide()">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger mb-10 p-5" role="alert">
                            <h4 class="alert-heading">Error!</h4>
                            <p>{{ Session::get('error_message') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Container-->
        @yield('content')
        <!--end::Container-->
    </div>
    <!--end::Main-->

    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#0BB783",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#D7F9EF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ $adminAssets }}js/plugins.bundle.js"></script>
    <!-- <script src="/keen/theme/demo3/dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=2.0.8"></script> -->
    <script src="{{ $adminAssets }}js/scripts.bundle.js"></script>
    <script src="{{ $adminAssets }}js/custom-common.js"></script>
    @stack('scripts')
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ $adminAssets }}js/widgets.js"></script>
    <script src="{{ $adminAssets }}js/login.js"></script>
    <!--end::Page Scripts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</body>
<!--end::Body-->

</html>
