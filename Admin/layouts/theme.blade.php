<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta charset="utf-8" />
    <title><?php bloginfo('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ $adminAssets }}css/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{ $adminAssets }}css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script src="{{ asset('vendors/angular-js/angular.min.js') }}"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo asset('/'); ?>favicon.ico">

    <?php
    // admin header
    do_action('admin_head');
    ?>
    <style>
        .mk-select2-container-wrap .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->


<body ng-app='myApp' ng-cloak='Loading...' id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled page-loading admin-body">

    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile header-mobile-fixed">
        <!--begin::Logo-->
        <a href="{{ APP_URL }}" target="_blank">
            <img alt="Logo" src="<?php echo get_store_logo_url(); ?>" class="mobile-admin-logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <button class="btn p-0 rounded-0 ml-4" id="kt_header_mobile_toggle">
                <span class="svg-icon svg-icon-xxl">
                    <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                            <path
                                d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <button class="btn rounded-0 p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header header-fixed">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Header Menu Wrapper-->
                        <div class="d-none d-lg-flex align-items-center mr-3">
                            <!--begin::Logo-->
                            <a href="{{ route('admin.dashboard') }}" class="mr-20">
                                <img alt="Logo" src="<?php echo get_store_logo_url(); ?>" class="max-h-60px">
                            </a>
                            <!--end::Logo-->
                        </div>

                        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            <!--begin::Header Menu-->
                            <div id="kt_header_menu"
                                class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                                <!--begin::Header Nav-->

                                <ul class="menu-nav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('admin.dashboard') }}" class="menu-link">
                                            <span class="menu-text">Dashboard</span>
                                        </a>
                                    </li>


                                    <?php do_action('before_manage_site_admin_menu'); ?>

                                    <?php do_action('after_manage_site_admin_menu'); ?>

                                    <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                        aria-haspopup="true">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <span class="menu-text">Users</span>
                                            <span class="menu-desc"></span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                            <ul class="menu-subnav">
                                                <li class="menu-item menu-item-submenu" data-menu-toggle="hover"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('admin.users', ['user_type' => 'user']) }}"
                                                        class="menu-link">
                                                        <span class="svg-icon menu-icon fa fa-bars">
                                                        </span>
                                                        <span class="menu-text">All Users</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item menu-item-submenu" data-menu-toggle="hover"
                                                    aria-haspopup="true">
                                                    <a href="{{ route('admin.adduser', ['user_type' => 'user']) }}"
                                                        class="menu-link">
                                                        <span class="svg-icon menu-icon fa fa-plus">
                                                        </span>
                                                        <span class="menu-text">Add New</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <?php do_action('before_manage_my_profile_admin_menu'); ?>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ route('user.profile') }}" class="menu-link">
                                            <span class="menu-text">My Profile</span>
                                        </a>
                                    </li>

                                    <?php do_action('extend_admin_menu'); ?>

                                </ul>
                                <!--end::Header Nav-->
                            </div>
                            <!--end::Header Menu-->
                        </div>
                        <!--end::Header Menu Wrapper-->
                        <!--begin::Topbar-->
                        <div class="topbar">
                            <!--begin::Search-->
                            <!--begin::Search-->
                            {{--                        <div class="dropdown mr-1" id="kt_quick_search_toggle"> --}}
                            {{--                            <!--begin::Toggle--> --}}
                            {{--                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px"> --}}
                            {{--                                <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg"> --}}
                            {{--                                        <span class="svg-icon svg-icon-xl"> --}}
                            {{--                                            <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/General/Search.svg--> --}}
                            {{--                                            <svg xmlns="http://www.w3.org/2000/svg" --}}
                            {{--                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" --}}
                            {{--                                                 viewBox="0 0 24 24" version="1.1"> --}}
                            {{--                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                            {{--                                                    <rect x="0" y="0" width="24" height="24"/> --}}
                            {{--                                                    <path --}}
                            {{--                                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" --}}
                            {{--                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/> --}}
                            {{--                                                    <path --}}
                            {{--                                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" --}}
                            {{--                                                            fill="#000000" fill-rule="nonzero"/> --}}
                            {{--                                                </g> --}}
                            {{--                                            </svg> --}}
                            {{--                                            <!--end::Svg Icon--> --}}
                            {{--                                        </span> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            {{--                            <!--end::Toggle--> --}}
                            {{--                            <!--begin::Dropdown--> --}}
                            {{--                            <div --}}
                            {{--                                    class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg"> --}}
                            {{--                                <div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown"> --}}
                            {{--                                    <!--begin:Form--> --}}
                            {{--                                    <form method="get" class="quick-search-form"> --}}
                            {{--                                        <div class="input-group"> --}}
                            {{--                                            <div class="input-group-prepend"> --}}
                            {{--                                                    <span class="input-group-text"> --}}
                            {{--                                                        <span class="svg-icon svg-icon-lg"> --}}
                            {{--                                                            <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/General/Search.svg--> --}}
                            {{--                                                            <svg xmlns="http://www.w3.org/2000/svg" --}}
                            {{--                                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" --}}
                            {{--                                                                 height="24px" viewBox="0 0 24 24" version="1.1"> --}}
                            {{--                                                                <g stroke="none" stroke-width="1" fill="none" --}}
                            {{--                                                                   fill-rule="evenodd"> --}}
                            {{--                                                                    <rect x="0" y="0" width="24" height="24"/> --}}
                            {{--                                                                    <path --}}
                            {{--                                                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" --}}
                            {{--                                                                            fill="#000000" fill-rule="nonzero" --}}
                            {{--                                                                            opacity="0.3"/> --}}
                            {{--                                                                    <path --}}
                            {{--                                                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" --}}
                            {{--                                                                            fill="#000000" fill-rule="nonzero"/> --}}
                            {{--                                                                </g> --}}
                            {{--                                                            </svg> --}}
                            {{--                                                            <!--end::Svg Icon--> --}}
                            {{--                                                        </span> --}}
                            {{--                                                    </span> --}}
                            {{--                                            </div> --}}
                            {{--                                            <input type="text" class="form-control" placeholder="Search..."/> --}}
                            {{--                                            <div class="input-group-append"> --}}
                            {{--                                                    <span class="input-group-text"> --}}
                            {{--                                                        <i class="quick-search-close ki ki-close icon-sm text-muted"></i> --}}
                            {{--                                                    </span> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                    </form> --}}
                            {{--                                    <!--end::Form--> --}}
                            {{--                                    <!--begin::Scroll--> --}}
                            {{--                                    <div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" --}}
                            {{--                                         data-mobile-height="200"></div> --}}
                            {{--                                    <!--end::Scroll--> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            {{--                            <!--end::Dropdown--> --}}
                            {{--                        </div> --}}
                            <!--end::Search-->

                            <div class="topbar-item mr-3">
                                <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2"
                                    id="kt_quick_user_toggle">
                                    <span class="svg-icon svg-icon-xl">
                                        <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/General/User.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path
                                                    d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                <path
                                                    d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>

                            <!--begin::Quick Actions-->
                            <div class="dropdown d-none">
                                <!--begin::Toggle-->
                                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                    <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1">
                                        <span class="svg-icon svg-icon-xl">
                                            <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                    fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                                        height="16" rx="1.5" />
                                                    <rect fill="#000000" x="8" y="9" width="3" height="11"
                                                        rx="1.5" />
                                                    <rect fill="#000000" x="18" y="11" width="3" height="9"
                                                        rx="1.5" />
                                                    <rect fill="#000000" x="3" y="13" width="3" height="7"
                                                        rx="1.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                </div>
                                <!--end::Toggle-->
                                <!--begin::Dropdown-->
                                <div
                                    class="d-none dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                                    <!--begin:Header-->
                                    <div class="d-flex flex-column flex-center py-10 rounded-to border-bottom">
                                        <h4 class="text-dark font-weight-bold">Quick Actions</h4>
                                        <span class="btn btn-primary btn-sm font-weight-bold font-size-sm mt-2">23 new
                                            tasks</span>
                                    </div>
                                    <!--end:Header-->
                                    <!--begin:Nav-->
                                    <div class=" d-none row row-paddingless">
                                        <!--begin:Item-->
                                        <div class="col-6">
                                            <a href="#"
                                                class="d-block py-10 px-5 text-center bg-hover-light border-right border-bottom">
                                                <span class="svg-icon svg-icon-3x svg-icon-primary">
                                                    <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/icons/Shopping/Sale2.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <polygon fill="#000000" opacity="0.3"
                                                                points="12 20.0218549 8.47346039 21.7286168 6.86905972 18.1543453 3.07048824 17.1949849 4.13894342 13.4256452 1.84573388 10.2490577 5.08710286 8.04836581 5.3722735 4.14091196 9.2698837 4.53859595 12 1.72861679 14.7301163 4.53859595 18.6277265 4.14091196 18.9128971 8.04836581 22.1542661 10.2490577 19.8610566 13.4256452 20.9295118 17.1949849 17.1309403 18.1543453 15.5265396 21.7286168" />
                                                            <polygon fill="#000000"
                                                                points="14.0890818 8.60255815 8.36079737 14.7014391 9.70868621 16.049328 15.4369707 9.950447" />
                                                            <path
                                                                d="M10.8543431,9.1753866 C10.8543431,10.1252593 10.085524,10.8938719 9.13585777,10.8938719 C8.18793881,10.8938719 7.41737243,10.1252593 7.41737243,9.1753866 C7.41737243,8.22551387 8.18793881,7.45690126 9.13585777,7.45690126 C10.085524,7.45690126 10.8543431,8.22551387 10.8543431,9.1753866"
                                                                fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M14.8641422,16.6221564 C13.9162233,16.6221564 13.1456569,15.8535438 13.1456569,14.9036711 C13.1456569,13.9520555 13.9162233,13.1851857 14.8641422,13.1851857 C15.8138085,13.1851857 16.5826276,13.9520555 16.5826276,14.9036711 C16.5826276,15.8535438 15.8138085,16.6221564 14.8641422,16.6221564 Z"
                                                                fill="#000000" opacity="0.3" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span
                                                    class="d-block text-dark-75 font-weight-bold font-size-h6 mt-2 mb-1">Accounting</span>
                                                <span class="d-block text-dark-50 font-size-lg">eCommerce</span>
                                            </a>
                                        </div>
                                        <!--end:Item-->

                                    </div>
                                    <!--end:Nav-->
                                </div>
                                <!--end::Dropdown-->
                            </div>
                            <!--end::Quick Actions-->

                            <!--end::Dropdown-->
                        </div>
                        <!--end::Topbar-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Subheader-->
                <div class="subheader bg-white h-100px" id="kt_subheader">
                    <div class="container flex-wrap flex-sm-nowrap">
                        <!--begin::Logo-->
                        <div class="d-none bk-d-lg-flex align-items-center flex-wrap w-250px">
                            <!--begin::Logo-->
                            <a href="<?php echo route('admin.dashboard'); ?>">
                                <img alt="Logo" src="<?php echo get_store_logo_url(); ?>" class="admin-logo img-fluid" />
                            </a>
                            <!--end::Logo-->
                        </div>
                        <!--end::Logo-->
                        <!--begin::Nav-->
                        <div class="subheader-nav nav flex-grow-1">
                            <?php do_action('admin_subheader'); ?>
                        </div>
                        <!--end::Nav-->
                    </div>
                </div>
                <!--end::Subheader-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="gutter-b" id="kt_breadcrumbs">
                        <div
                            class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center flex-wrap mr-1">
                                <!--begin::Page Heading-->
                                <div class="d-flex align-items-baseline flex-wrap mr-5">

                                    <!--begin::Page Title-->
                                    {{-- <h4 class="text-dark font-weight-bold my-1 mr-5">Stores</h4> --}}
                                    <!--end::Page Title-->
                                    <!--begin::Breadcrumb-->
                                    <ul
                                        class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0)" class="text-dark-50">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0)" class="text-dark-50">@yield('menu_title')</a>
                                        </li>
                                    </ul>
                                    <!--end::Breadcrumb-->

                                </div>
                                <!--end::Page Heading-->
                            </div>
                            <!--end::Info-->
                            {{-- Error class div --}}
                        </div>
                    </div>

                    <!--begin::Entry-->
                    {{-- <div class="d-flex flex-column-fluid"> --}}

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

                    <div class="container success-error d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success mb-10 p-5" role="alert">
                                    <h4 class="alert-heading">Success!</h4>
                                    <div class="error_html">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container danger-error d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger mb-10 p-5" role="alert">
                                    <h4 class="alert-heading">Error!</h4>
                                    <div class="error_html">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Container-->
                    @yield('content')
                    <!--end::Container-->
                    {{-- </div> --}}
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted font-weight-bold mr-2">Copyright &COPY;<?php echo date('Y'); ?>
                                {{ env('APP_NAME') }}. All Rights Reserved.
                                <span class="d-none">&nbsp;|&nbsp; Developed & Maintained by</span>
                                <a class="d-none" href="<?php echo get_developer_details('site_url'); ?>"><?php echo get_developer_details('site_name'); ?></a>
                                <span class="d-none">&nbsp;|&nbsp;</span>
                                <a class="d-none" href="tel:<?php echo get_developer_details('mobile'); ?>">Contact developer</a>
                            </span>
                            <a href="{{ APP_URL }}" target="_blank"
                                class="text-dark-75 text-hover-primary"></a>
                        </div>
                        <!--end::Copyright-->
                        <!--begin::Nav-->
                        <div class="nav nav-dark order-1 order-md-2 d-none">
                            <a href="" target="_blank" class="nav-link pr-3 pl-0">About</a>
                            <a href="" target="_blank" class="nav-link px-3">Team</a>
                            <a href="" target="_blank" class="nav-link pl-3 pr-0">Contact</a>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5" kt-hidden-height="40"
            style="">
            <h3 class="font-weight-bold m-0">Welcome
                {{-- <small class="text-muted font-size-sm ml-2">15 messages</small> --}}
            </h3>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="fa fa-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5 scroll ps ps--active-y" style="height: 378px; overflow: hidden;">
            <!--begin::Header-->
            <div class="d-flex align-items-center mt-5">
                <div class="symbol symbol-100 mr-5">
                    <div class="symbol-label" style="background-image:url('<?php echo get_current_user_profile_url(); ?>')"></div>
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div class="d-flex flex-column">
                    <a href="#"
                        class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?php echo get_current_user_full_name(); ?></a>
                    <div class="text-muted mt-1"><?php echo get_current_user_role_text(); ?></div>
                    <div class="navi mt-2">
                        <a href="#" class="navi-item">
                            <span class="navi-link p-0 pb-2">
                                <span class="navi-icon mr-1">
                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-notification.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path
                                                    d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                    fill="#000000"></path>
                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5"
                                                    r="2.5"></circle>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="navi-text text-muted text-hover-primary"><?php echo get_current_user_email(); ?></span>
                            </span>
                        </a>
                        <a href="{{ get_logout_url() }}"
                            class="btn btn-sm btn-primary font-weight-bolder py-2 px-5">Sign Out</a>
                    </div>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Separator-->
            <div class="separator separator-dashed mt-8 mb-5"></div>
            <!--end::Separator-->
            <!--begin::Nav-->
            <div class="navi navi-spacer-x-0 p-0">

                <a href="<?php echo route('user.profile'); ?>" class="navi-item">
                    <div class="navi-link">
                        <div class="symbol symbol-40 bg-light mr-3">
                            <div class="symbol-label">
                                <span class="svg-icon svg-icon-md svg-icon-success">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Notification2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                                fill="#000000"></path>
                                            <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5"
                                                r="2.5"></circle>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                        <div class="navi-text">
                            <div class="font-weight-bold">My Profile</div>
                            <div class="text-muted">Account settings and more
                                <span class="label label-light-danger label-inline font-weight-bold">update</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!--end::Nav-->
            <!--begin::Separator-->
            <div class="separator separator-dashed my-7"></div>
            <!--end::Separator-->
            <!--begin::Notifications-->

            <!--end::Notifications-->
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; height: 378px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 135px;"></div>
            </div>
        </div>
        <!--end::Content-->
    </div>

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
    <script>
        var angularApp = angular.module('myApp', []);
        // show required span html
        angularApp.component('requiredSpan', {
            template: '<span class="required text-danger">*</span>',
        });
        //check_obj_length
        angularApp.filter('check_obj_length', function() {
            return function(object) {
                return Object.keys(object).length;
            }
        });
        // bind angular js scope
        function bindAjs($scope) {
            if (!$scope.$$phase) {
                $scope.$apply();
            }
        }
    </script>
    @stack('scripts')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ $adminAssets }}js/widgets.js"></script>
    <!--end::Page Scripts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php do_action('admin_footer'); ?>
</body>
<!--end::Body-->

</html>
