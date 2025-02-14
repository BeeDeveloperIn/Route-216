@extends($themeLayoutPath)
@section('content')
    <style>
        .login-left-sidebar-bg {
            background-image: url('<?php echo apply_filters('login_screen_logo_url', get_store_logo_url()); ?>');
            /* background-image: url('<?php echo asset('store/login-bg.jpg'); ?>'); */
            background-repeat: no-repeat;
            background-size: 100%;
            background-position: center center;
        }
    </style>
    <?php
    $login_background_color = apply_filters('login_screen_bg_color', '#1B2C85');
    ?>
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto login-left-sidebar-bg"
            style="background-color: <?php echo $login_background_color; ?>;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <!-- <a href="#" class="text-center mb-15 d-done">
                                                                <img src="<?php //echo apply_filters('login_screen_logo_url', get_store_logo_url());
                                                                ?>" alt="logo"
                                                                     class="img-fluid">
                                                            </a> -->
                <!--end::Aside header-->
                <!--begin::Aside title-->
                <?php
                $login_featured_heading = apply_filters('login_featured_heading', '');
                if($login_featured_heading){
                ?>
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">
                    <?php
                    echo $login_featured_heading;
                    ?>
                </h3>
                <?php
            }
            ?>

                <!--end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div
            class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">


                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->

                    <form id="kt_login_signin_form" class="form fv-plugins-bootstrap fv-plugins-framework"
                        novalidate="novalidate" action="{{ route('admin.login') }}" method="post">
                        {!! csrf_field() !!}
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">

                            <img src="<?php echo apply_filters('login_screen_logo_url', get_store_logo_url()); ?>" alt="logo" class="img-fluid d-none">

                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">
                                <?php echo apply_filters('login_form_entry_heading', 'Login'); ?>
                            </h3>

                            <span class="text-muted font-weight-bold font-size-h4 d-none">New Here?
                                <a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder">Create
                                    an Account</a></span>
                        </div>

                        <?php if($error){?>
                        <div class="alert alert-danger mb-10 p-5" role="alert">
                            <h4 class="alert-heading">Error!</h4>
                            <div class="error_html"><?php echo $error; ?></div>
                        </div>
                        <?php }?>

                        <!--begin::Title-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email<span
                                    class="text-danger">*</span></label>
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg"
                                value="<?php echo $email; ?>" placeholder="Enter your email" type="text" name="email"
                                autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password<span
                                        class="text-danger">*</span></label>
                                <a href="<?php echo route('web.lost_password', ['user_type' => 'user']); ?>"
                                    class="d-none text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot
                                    Password ?</a>
                            </div>
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg" type="password"
                                name="password" autocomplete="off" placeholder="Enter your password"
                                value="<?php echo $password; ?>">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->

                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-3">
                            <div class="checkbox-inline">
                                <label class="checkbox checkbox-outline m-0 text-muted">
                                    <input value="1" type="checkbox" name="remember">
                                    <span></span>
                                    Remember me
                                </label>
                            </div>
                            <a href="javascript:;" id="kt_login_forgot"
                                class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password
                                ?</a>
                        </div>

                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit"
                                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In
                            </button>
                            {{-- <button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:/keen/theme/demo3/dist/assets/media/svg/social-icons/google.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M19.9895 10.1871C19.9895 9.36767 19.9214 8.76973 19.7742 8.14966H10.1992V11.848H15.8195C15.7062 12.7671 15.0943 14.1512 13.7346 15.0813L13.7155 15.2051L16.7429 17.4969L16.9527 17.5174C18.879 15.7789 19.9895 13.221 19.9895 10.1871Z" fill="#4285F4"></path>
                                    <path d="M10.1993 19.9313C12.9527 19.9313 15.2643 19.0454 16.9527 17.5174L13.7346 15.0813C12.8734 15.6682 11.7176 16.0779 10.1993 16.0779C7.50243 16.0779 5.21352 14.3395 4.39759 11.9366L4.27799 11.9466L1.13003 14.3273L1.08887 14.4391C2.76588 17.6945 6.21061 19.9313 10.1993 19.9313Z" fill="#34A853"></path>
                                    <path d="M4.39748 11.9366C4.18219 11.3166 4.05759 10.6521 4.05759 9.96565C4.05759 9.27909 4.18219 8.61473 4.38615 7.99466L4.38045 7.8626L1.19304 5.44366L1.08875 5.49214C0.397576 6.84305 0.000976562 8.36008 0.000976562 9.96565C0.000976562 11.5712 0.397576 13.0882 1.08875 14.4391L4.39748 11.9366Z" fill="#FBBC05"></path>
                                    <path d="M10.1993 3.85336C12.1142 3.85336 13.406 4.66168 14.1425 5.33717L17.0207 2.59107C15.253 0.985496 12.9527 0 10.1993 0C6.2106 0 2.76588 2.23672 1.08887 5.49214L4.38626 7.99466C5.21352 5.59183 7.50242 3.85336 10.1993 3.85336Z" fill="#EB4335"></path>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Sign in with Google</button> --}}
                        </div>
                        <!--end::Action-->
                        <input type="hidden">
                        <div></div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->

                <!--begin::Signup-->
                <div class="login-form login-signup">
                    <!--begin::Form-->
                    <form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate"
                        id="kt_login_signup_form">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your
                                account
                            </p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="text"
                                placeholder="Fullname" name="fullname" autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email"
                                placeholder="Email" name="email" autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6"
                                type="password" placeholder="Password" name="password" autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6"
                                type="password" placeholder="Confirm password" name="cpassword" autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex align-items-center fv-plugins-icon-container">
                            <label class="checkbox mb-0">
                                <input type="checkbox" name="agree">
                                <span></span>
                            </label>
                            <div class="pl-2">I Agree the
                                <a href="#" class="ml-1">terms and conditions</a>
                            </div>
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                            <button type="button" id="kt_login_signup_submit"
                                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit
                            </button>
                            <button type="button" id="kt_login_signup_cancel"
                                class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel
                            </button>
                        </div>
                        <!--end::Form group-->
                        <div></div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signup-->

                <!--begin::Forgot-->
                <div class="login-form login-forgot">
                    <!--begin::Form-->
                    <form onsubmit="send_reset_password_code()" class="form fv-plugins-bootstrap fv-plugins-framework"
                        id="kt_login_forgot_form">

                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password
                                ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your
                                password. We will send an verificaion code to your email address.</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group fv-plugins-icon-container">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email <span
                                    class="text-danger">*</span></label>
                            <input value="manojit1611@gmail.com" required
                                class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email"
                                placeholder="Email" name="email" autocomplete="off">
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                            <button type="submit" id="kt_login_forgot_submit"
                                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Send Code
                            </button>
                            <button type="button" id="kt_login_forgot_cancel"
                                class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Back
                            </button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->

                    <!--begin::Form-->
                    <form style="display: none" onsubmit="reset_password_via_code()" class="form"
                        id="kt_reset_password_form" autocomplete="off">
                        <input type="hidden" name="hash" class="js-rp-hash">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Password</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter verification code and reset your
                                password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Verification code <span
                                    class="text-danger">*</span></label>
                            <input required class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6"
                                type="text" minlength="6" maxlength="6" placeholder="Verification code"
                                name="code" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">New Password <span
                                    class="text-danger">*</span></label>
                            <input required class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6"
                                type="password" placeholder="New password" name="password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input required class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6"
                                type="password" placeholder="Confirm password" name="confirm_password"
                                autocomplete="off">
                        </div>

                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-2">
                            <button type="submit"
                                class="btn btn-primary font-weight-bolder font-size-h6 px-9 py-4 my-3">Verify &
                                Reset</button>
                            <div class="my-3 ml-2">
                                {{-- <span class="text-muted mr-2">Back to</span> --}}
                                <a href="{{ route('admin.login') }}"
                                    class="text-primary font-size-h6 font-weight-bolder text-hover-primary">Back To
                                    Login</a>
                            </div>
                        </div>
                        <!--end::Form group-->

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->


            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <div class="mk-d-flex d-none justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <a target="_blank" class="text-primary font-weight-bolder font-size-h5"
                    href="<?php echo get_developer_details('site_url'); ?>">Developed & Maintained
                    by: <?php echo get_developer_details('site_name'); ?></a>
            </div>
            <!--end::Content footer-->
        </div>
        <!--end::Content-->
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // setTimeout(() => {
            //     $('#kt_login_forgot').trigger('click');
            // }, 300);
        });
        var sentResetPasswordRes = {};
        var kt_login_forgot_formEl = $("#kt_login_forgot_form");
        var kt_reset_password_formEl = $("#kt_reset_password_form");

        /**
         * showResetPasswordForm
         * Show reset password form
         */
        function showResetPasswordForm() {
            // set hash in hidden
            kt_reset_password_formEl.find('.js-rp-hash').val(sentResetPasswordRes.data.hash);
            // hide main form 
            kt_login_forgot_formEl.hide();
            // show reset password form 
            kt_reset_password_formEl.show();
        }

        /**
         * hideResetPasswordForm
         * Hide reset password form
         */
        function hideResetPasswordForm() {
            // reset hash from hidden 
            // blank old sent code res
            sentResetPasswordRes = {};

            // hide reset password form 

            // show forgot password form
        }

        /**
         * send_reset_password_code
         * Send reset password code to email 
         */
        function send_reset_password_code() {
            event.preventDefault();
            let formEl = kt_login_forgot_formEl;
            formData = formEl.serialize();
            $.ajax({
                url: '{{ route('api.sendResetPasswordCode', ['via' => 'email']) }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    preloaderOn();
                },
                success: function(response) {
                    sentResetPasswordRes = response; // set for further use
                    preloaderOff();
                    showGlobalToast(response);
                    console.log("Reset password response", response);
                    if (response.succ) {
                        showResetPasswordForm();
                    }
                }
            });
        }

        /**
         * reset_password_via_code
         */
        function reset_password_via_code() {
            event.preventDefault();
            let formEl = kt_reset_password_formEl;
            formData = formEl.serialize();
            $.ajax({
                url: '{{ route('api.resetPasswordViaCode', ['via' => 'email']) }}',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    preloaderOn();
                },
                success: function(response) {
                    preloaderOff();
                    showGlobalToast(response);
                    if (response.succ) {
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.login') }}";
                        }, 1000);
                    }
                }
            });
        }
    </script>
@endpush
