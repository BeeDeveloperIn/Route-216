@extends($themeLayoutPath)
@section('menu_title')
    {{ @$cap['cap_id'] ? 'Update' : 'Add' }} permission
@endsection
@section('content')
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ @$cap['cap_id'] ? 'Update' : 'Add' }} permission</h3>
                    <div class="card-toolbar text-right">
                        <div class="example-tools justify-content-center">
                            <a href="<?php echo route('admin.roleCaps'); ?>" class="btn btn-secondary">All {{ \Illuminate\Support\Str::plural('permission') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.rolecaps.store') }}">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="{{ @$cap['cap_id'] }}">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Name
                                    <required-span></required-span>
                                </label>
                                <input required type="text" class="form-control" name="cap_name"
                                       placeholder="Enter the capability name" value="{{@$cap['cap_name']}}">
                            </div>

                            <div class="form-group">
                                <label>Slug
                                    <required-span></required-span>
                                </label>
                                <input required type="text" class="form-control" name="cap_slug"
                                       placeholder="Enter the capability slug" value="{{@$cap['cap_slug']}}">
                            </div>

                            <div class="form-group">
                                <label>Status
                                    <required-span></required-span>
                                </label>
                                <select required class="form-control" name="status">
                                    <option value="">-- Select --</option>
                                    <option {{@$cap['status'] == '1' ? 'selected' : ''}} value="1">Enable</option>
                                    <option {{@$cap['status'] == '0' ? 'selected' : ''}} value="0">Disable</option>
                                </select>
                            </div>

                            <?php
                            if(is_root_admin()){
                            ?>
                            <div class="form-group">
                                <label>Is strict?
                                    <required-span></required-span>
                                </label>
                                <select required class="form-control" name="strict">
                                    <option value="">-- Select --</option>
                                    <option {{@$cap['strict'] == '1' ? 'selected' : ''}} value="1">Yes</option>
                                    <option {{@$cap['strict'] == '0' ? 'selected' : ''}} value="0">No</option>
                                </select>
                            </div>
                            <?php
                            }
                            ?>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary spinner-white spinner-right submit-button">
                                    {{ @$cap['cap_id'] ? 'Update' : 'Add' }}
                                </button>
                                <a href="<?php echo route('admin.addRoleCaps'); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Roles
                                <required-span></required-span>
                            </label>
                            <div class="roles-list">
                                @foreach($roles as $eachRole)
                                    <label class="checkbox mr-2 mb-2">
                                        <input type="checkbox" name="roles[]" value="{{$eachRole['role_id']}}"
                                               class="shipping-method" {{ (isset($eachRole['checked']) && $eachRole['checked'] == 1) ? 'checked' : '' }}>
                                        <span class="mr-1"></span> {{$eachRole['role']}}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection