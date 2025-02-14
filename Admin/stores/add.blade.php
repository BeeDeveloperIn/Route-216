@extends($themeLayoutPath)
@section('menu_title')
Stores
@endsection
@section('content')
<div class="container">
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                @if ($store == null)
                <h3 class="card-label">{{ __('store.title_add_store') }}</h3>
                @else
                <h3 class="card-label">{{ __('store.title_update_store') }}</h3>
                @endif

                <div class="card-toolbar text-right">
                    <div class="example-tools justify-content-center">
                        <a href="{{ route('admin.stores') }}" class="btn btn-secondary">Store list</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
           <div class="row">
            <div class="col-md-12 form-group">
                <form>
                    <div class="row">
                        <div class="col-md-12 form-group">
                                <label>{{ __('store.term') }} Name <span class="required">*</span></label>
                                <input type="text" class="form-control" placeholder="{{ __('store.term') }} Name">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Country code <span class="required">*</span></label>
                            <input type="text" class="form-control" placeholder="{{ __('store.term') }} country code">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>State code <span class="required">*</span></label>
                        <input type="text" class="form-control" placeholder="{{ __('store.term') }} state code">
                </div>
                <div class="col-md-4 form-group">
                    <label>Pincode <span class="required">*</span></label>
                    <input type="text" class="form-control" placeholder="{{ __('store.term') }} pincode">
            </div>
                <div class="col-md-12 form-group">
                    <label>Address line 1 <span class="required">*</span></label>
                    <textarea placeholder="Address line 1" class="form-control"></textarea>
                </div>
                <div class="col-md-12 form-group">
                    <label>Address line 2 <span class="required">Optional</span></label>
                    <textarea placeholder="Address line 2" class="form-control"></textarea>
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" class="btn btn-primary">{{ __('store.form_submit_btn_text') }}</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
                </div>
                </form>
           </div>
    </div>

</div>
</div>
@endsection
