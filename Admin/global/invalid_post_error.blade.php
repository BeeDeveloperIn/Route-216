@extends($themeLayoutPath)
@section('menu_title')
{{ __('post.invalid_post_text') }}
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-custom alert-outline-danger" role="alert">
                        <div class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div>
                        <div class="alert-text">{{ __('post.invalid_post_msg') }}</div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
