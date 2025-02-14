@extends('admin.users.layouts.add')
@if(is_admin() || is_root_admin())
@section('role_input')
    <div class="col-md-4 form-group">
        <label>Role <span class="text-danger">*</span></label>
        <select class="form-control" ng-model="user.role_id" ng-value="user.role_id">
            <option disabled value="">Select Role</option>
            {{--            <option value="<?php echo ROLE_ADMIN;?>">Admin</option>--}}
            {{--            <option value="<?php echo ROLE_SEO_USER;?>">Seo manager</option>--}}
            <option ng-repeat='(key,eachRole) in user_roles' value="@{{ eachRole.role_id }}">
                @{{ eachRole.role }}
            </option>
        </select>
    </div>
@endsection
@endif