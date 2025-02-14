<?php
get_header();
if (function_exists('get_page_breadcrumb')) {
    # set post
    global $post;
    $post['name'] = "Reset password";
    get_page_breadcrumb();
}
?>
<section class="reset-password ptb-70 reset-password-content">
    <div class="container">
        <div class="row">
            @if($errors->any())
            <div class="col-md-12 form-group">
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger" role="alert">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div class="col-md-12">

                    <form action="<?php echo route('web.update_password') ?>" method="POST">
                        @csrf
                        <input type="hidden" name="hash" value="<?php echo $reset_password_hash; ?>">
                        <input type="hidden" name="type_hash" value="<?php echo $type_hash; ?>">
                        <input type="hidden" name="verification_id" value="<?php echo $verification_id; ?>">


                        <div class="form-group">
                            <label>New password</label>
                            <input required type="password" name="password" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label>Confirm password</label>
                            <input required type="password" name="confirm_password" class="form-control" placeholder="Enter confirm password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update password</button>
                    </form>
                </div>

        </div>

    </div>
</section>
<style>
    @media screen and (min-width:992px) {
        .reset-password-content {
                max-width: 560px;
            margin: 0 auto;
        }
    }
</style>
<?php
get_footer();
?>
