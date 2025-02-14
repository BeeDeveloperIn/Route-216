<?php
get_header();
?>
<section class="ptb-70">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>
                    Your password Has been changed!
                </h2>
                <h6 class="text-warning">Please wait we are redirecting you to homepage...</h6>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
    // Your code to run since DOM is loaded and ready
    setTimeout(function() {
        window.location.href='<?php echo route('web.index')?>';
        }, 1500);
});
</script>
<?php
get_footer();
?>