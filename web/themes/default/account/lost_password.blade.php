<?php
get_header();

if(function_exists('get_page_breadcrumb')){
    # set post
    global $post;
    $post['name'] = "Lost password";
    get_page_breadcrumb();
}

?>
<section class="lost-password-content <?php echo $user_type; ?>  ptb-70">

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
                <div class="entry-heading mb-3">
                <p>Lost your password? Please enter your email address. You will receive a link to create a new password via email.</p>
                </div>
            </div>

            <div class="col-md-12">
                <form method="POST" action="<?php echo route('web.send_reset_password_link', ['via' => 'email']) ?>" class="lost-password">
                    <input type="hidden" name="user_type" value="<?php echo $user_type; ?>">
                    @csrf
                    <!-- {{ csrf_field() }} -->
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Email address:</label>
                            <input required type="email" name="email" placeholder="Enter email address" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Reset password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<style>
    @media screen and (min-width:992px) {
        .lost-password-content {
            max-width: 560px;
            margin: 0 auto;
        }
    }
</style>
<?php
get_footer();
?>
