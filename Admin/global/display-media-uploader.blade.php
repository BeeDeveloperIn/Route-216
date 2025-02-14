@extends($themeLayoutPath)
@section('menu_title')
    Media uploader
@endsection
@section('content')
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Media uploader</h3>

                </div>
            </div>
            <div class="card-body">
                <iframe class="w-100 border-0" style="height: 100vh" src="{{ route('admin.image.upload') }}"></iframe>
            </div>
        </div>
    </div>

@endsection
