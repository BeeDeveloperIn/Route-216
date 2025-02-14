@extends($themeLayoutPath)
@section('menu_title')
    Manage profile
@endsection
@section('content')
    <div class="container" ng-controller="userController" id="userController" ng-cloak='Processing..'>
        <!--begin::Profile Change Password-->
        <div class="d-flex flex-row">
            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url('<?php echo get_current_user_profile_url(); ?>')"></div>
                                <i class=" symbol-badge bg-success"></i>
                            </div>
                            <div>
                                <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                                    <?php echo get_current_user_full_name(); ?></a>
                                <div class="text-muted"><?php echo get_current_user_role_text(); ?></div>
                            </div>
                        </div>
                        <!--end::User-->
                        <!--begin::Contact-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Email:</span>
                                <a href="mailto:<?php echo get_current_user_email(); ?>"
                                    class="text-muted text-hover-primary"><?php echo get_current_user_email(); ?></a>
                            </div>
                            <div class="bk-d-flex align-items-center justify-content-between mb-2 d-none">
                                <span class="font-weight-bold mr-2">Phone:</span>
                                <span class="text-muted"><?php echo get_current_user_mobile(); ?></span>
                            </div>
                        </div>
                        <!--end::Contact-->
                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                            <div class="navi-item mb-2">
                                <a ng-click="changeAccountScreen('profile-info')"
                                    ng-class="{'active': tab==='profile-info'}" href="javascript:void(0)"
                                    class="navi-link py-4">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo9/dist/assets/media/svg/icons/General/User.svg-->
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
                                    </span>
                                    <span class="navi-text font-size-lg">Personal Information</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a ng-click="changeAccountScreen('change-password')" href="javascript:void(0)"
                                    ng-class="{'active': tab==='change-password'}" class="navi-link py-4 ">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo9/dist/assets/media/svg/icons/Communication/Shield-user.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path
                                                        d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                    <path
                                                        d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                    <path
                                                        d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text font-size-lg"><?php echo __('Change Password'); ?></span>
                                    <span class="navi-label">
                                        {{--																<span class="label label-light-danger label-rounded font-weight-bold">5</span> --}}
                                    </span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->
            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->
                <div ng-if="tab=='change-password'" class="card card-custom">
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account password</span>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="reset-password-form" ng-submit="change_password();" class="form">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" name="password_current"
                                        class="form-control form-control-lg form-control-solid mb-2" value=""
                                        placeholder="Current password">
                                    {{--                                    <a href="#" class="text-sm font-weight-bold">Forgot password ?</a> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" name="password"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="New password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" name="confirm_password"
                                        class="form-control form-control-lg form-control-solid" value=""
                                        placeholder="Verify password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button type="submit"
                                        class="btn btn-primary spinner-white spinner-right spinner-white spinner-right submit-button mr-2">
                                        Update password
                                    </button>
                                </div>

                            </div>

                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <div ng-if="tab=='profile-info'">
                    <div class="card card-custom mb-5">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Change Profile information</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account
                                    information</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="changeSelfProfileForm" ng-submit="changeSelfProfile()">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="Name">Name
                                            <required-span></required-span>
                                        </label>
                                        <input required minlength="3" maxlength="100" type="text" name="first_name"
                                            ng-model="userData.name" class="form-control d-none">

                                        <input required minlength="3" maxlength="100" type="text" name="name"
                                            ng-model="userData.name" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group d-none">
                                        <label for="Last Name">Last Name
                                            <required-span></required-span>
                                        </label>
                                        <input required="required" minlength="3" maxlength="100" type="text"
                                            name="last_name" ng-model="userData.last_name" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group d-none">
                                        <label for="Mobile">Mobile
                                            <required-span></required-span>
                                        </label>
                                        <input minlength="10" maxlength="10" type="text" name="mobile"
                                            ng-model="userData.mobile1" class="form-control">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email
                                            <required-span></required-span>
                                        </label>
                                        <input type="text" disabled ng-model="userData.email" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary spinner-white spinner-right submit-button">Update
                                            details
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-custom ">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Change Profile Image</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account profile
                                    picture</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form ng-submit="changeProfilePicture()" class="form-horizontal" id="updatePicture"
                                method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="input-group col-md-12">
                                        <input class="form-control" type="file" id="fileInput"
                                            name="fileInput" accept=".jpg,.jpeg,.png">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary spinner-white spinner-right submit-button">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Profile Change Password-->
    </div>
@endsection
@push('scripts')
    <?php
    if (get_current_user_id()){
        ?>
    <script type="text/javascript">
        var submitButtonClass = '.submit-button';
        angularApp.controller('userController', function($scope, $http) {
            $scope.tab = "profile-info";
            $scope.userData = @json($userData); // user data
            // change_password
            $scope.change_password = function() {
                event.preventDefault();
                let resetPassForm = $("#reset-password-form");
                $.ajax({
                    type: 'post',
                    url: '{{ route('users.update_password_req') }}',
                    dataType: 'json',
                    data: resetPassForm.serialize(),
                    beforeSend: function() {
                        resetPassForm.find(submitButtonClass).addClass('spinner');
                    },
                    success: function(response) {
                        show_html_error(response);
                        resetPassForm.find(submitButtonClass).removeClass('spinner');
                        if (response.succ) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                        bindAjs($scope);
                    }
                });
            }

            // Update self details
            $scope.changeSelfProfile = function() {
                event.preventDefault();
                let profileForm = $("#changeSelfProfileForm");
                $.ajax({
                    type: 'post',
                    url: '<?php echo route('users.updateSelfProfile'); ?>',
                    dataType: 'json',
                    data: profileForm.serialize(),
                    beforeSend: function() {
                        profileForm.find(submitButtonClass).addClass('spinner');
                    },
                    success: function(response) {
                        show_html_error(response);
                        profileForm.find(submitButtonClass).removeClass('spinner');
                        if (response.succ) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 500);
                        }
                        bindAjs($scope);
                    }
                });
            }
            $scope.changeAccountScreen = function(screen) {
                $scope.tab = screen;
            }

            // Change current user profile picture
            $scope.changeProfilePicture = function() {
                event.preventDefault();
                var formData = new FormData($('#updatePicture')[0]);
                let profileForm = $('#updatePicture');
                $.ajax({
                    url: '{{ route('users.updateProfileImage') }}',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function() {
                        profileForm.find(submitButtonClass).addClass('spinner');
                    },
                    success: function(response) {
                        show_html_error(response);
                        profileForm.find(submitButtonClass).removeClass('spinner');
                        if (response.succ) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                        bindAjs($scope);
                    }
                });
            }
        });
    </script>
    <?php
    }
    ?>
@endpush
