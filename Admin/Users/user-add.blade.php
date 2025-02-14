@extends('admin.users.layouts.add')
@if (is_admin() || is_root_admin())
    @section('role_input')
        <div class="col-md-3 form-group d-none">
            <label>Role <span class="text-danger">*</span></label>
            <select class="form-control" ng-model="user.role_id" ng-value="user.role_id">
                <option disabled value="">Select Role</option>
                <option ng-repeat='(key,eachRole) in user_roles' value="@{{ eachRole.role_id }}">
                    @{{ eachRole.role }}
                </option>
            </select>
        </div>
    @endsection
@endif
@section('user_form_end_extend')
    <div class="col-md-4 form-group">
        <label>Vat Number</label>
        <input maxlength="25" class="form-control" type="text"  pattern="^[a-zA-Z0-9]{8,30}$" title="Please enter a valid VAT number" ng-model="user.user_meta_data.vat_number">
    </div>
@endsection




@push('scripts')
@endpush
