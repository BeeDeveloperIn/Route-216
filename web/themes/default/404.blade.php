<?php
get_header();
?>
<section class="error-area ptb-70">
    <div class="container">
        <div class="error-content">
            <img src="{{ asset($current_theme_assets.'assets/img/error.png')}}" alt="image">
            <h3>Error 404 : Page Not Found</h3>
            <p>The page you are looking for might have been removed had its name changed or is temporarily
                unavailable.</p>
            {{--            <a href="#" class="btn btn-primary"><i class="flaticon-left-chevron"></i> Back to Homepage</a>--}}
        </div>
    </div>
</section>
<?php
get_footer();
?>


