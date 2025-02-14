@extends($themeLayoutPath)
@section('menu_title')
    Dashboard
@endsection
@section('content')
    <div class="container">
    <div class="row d-none">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Welcome back <?php echo get_current_user_full_name(); ?>. &#128522; </h3>
                            <!-- <div class="card-toolbar text-right">
                                <div class="example-tools justify-content-center">
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php do_action('mk_dashboard_setup'); ?>



    </div>
@endsection
