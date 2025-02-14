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

                    <h2>Description About the Application Users</h3>
                    <p>Route216 is designed for clients of accounting services and their accountants. It is ideal for those who need a reliable, secure, and easy way to manage and share financial documents and communicate with their accountant efficiently.</p>

                    <h2>Why We Need Access to the Gallery?</h2>
                    <p>Route216 requires access to the user's gallery to enable clients to easily upload existing images of documents, receipts, and other financial paperwork stored on their device. This feature is essential for ensuring that clients can seamlessly manage their financial records without the need for manual data entry or physical document storage. Access to the gallery enhances user convenience by allowing them to select and upload multiple documents from their device, supporting efficient document management and archival.</p>

                    <h2>Why We Need Access to the Camera?</h2>
                    <p>The camera access is crucial for Route216's core functionality, which allows users to directly capture images of receipts, invoices, and other financial documents in real-time. This feature supports our goal of simplifying the process of document submission, enabling immediate digitization of paper records, which is vital for timely and accurate financial reporting and analysis. Camera access ensures that the documents are captured clearly and uploaded instantly to the app, facilitating real-time document management and reducing the risk of data loss or entry errors.</p>

                    <h2>Privacy Policy</h3>
                    <p>Route216 is committed to protecting your privacy. Our app collects and uses personal information only to provide services as described in this app. We implement strong security measures to safeguard your data and do not share information with third parties without consent.</p>

                    <h2>Copyright</h3>
                    <p>Copyright © <?php echo date("Y");?> Route216 Ltd. All rights reserved. No part of this application may be reproduced or transmitted in any form without the prior written permission of the copyright owner.</p>
                    
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
