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
            class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto welcome">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin welcome">
                    <!--begin::Form-->

                    <h2>Welcome to Route216 – Streamlining Your Financials with Cutting-Edge Technology</h2>
                    <p>&nbsp;</p>
                    <h2>Empower Your Financial Management</h2>
                    <p>Discover the future of accounting with Route216, the innovative app designed to streamline the interaction between clients and accountants. No more lost paperwork, no more delays—just smooth, efficient financial management at your fingertips.</p>

                    <h2>Why Choose Route216?</h2>

                    <p>Effortless Document Management: Snap a photo of your receipts, invoices, and other financial documents, and upload them instantly. Route216 securely stores your documents, allowing both you and your accountant easy access anytime, anywhere.</p>

                    <p>24/7 Access to Financial Documents: Need to review a past tax return or financial statement? Route216 keeps all your essential documents stored safely in the cloud. Access your financial history from your phone, whenever you need it—simple and hassle-free.</p>

                    <p>Real-Time Communication: Have a question for your accountant? Route216’s built-in chat feature allows for instant communication. Get the answers you need quickly, without waiting for emails or phone calls.</p>

                    <p>User-Friendly Interface: Our app is designed with you in mind. Whether you’re tech-savvy or new to digital finance management, navigating Route216 is intuitive and straightforward.</p>

                    <p>Secure and Reliable: At Route216, security is our top priority. Your financial data is protected with industry-leading encryption and compliance measures, ensuring your information stays secure.</p>

                    <h2>Join the Revolution in Accounting</h2>
                    <p>Route216 is more than just an app—it's a new way to handle your finances with confidence and ease. Perfect for small businesses, freelancers, and anyone looking to take control of their financial management.</p>

                    <p>Download Route216 today and experience the difference. Ready to simplify your accounting? Let Route216 guide the way.</p>

                    <h2>Contact Us</h2>
                    <p>For support or more information, visit our <a style="text-decoration:underline;color:#000;" href="https://route216.eu/support">support page</a> or reach out directly through our app’s in-built messaging system. We’re here to help!</p>
                    
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
