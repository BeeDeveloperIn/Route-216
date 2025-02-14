@extends($themeLayoutPath)
@section('menu_title')
    @if (!isset($user['id']) || (isset($user['id']) && $user['id'] == ''))
        Add {{ $user_type }}
    @else
        Update {{ $user_type }}
    @endif
@endsection
@section('content')
    <div class="container" ng-controller="user-controller" id="user-controller">
        <div class="card card-custom gutter-b">

            <!--begin:: Card Header -->
            <div class="card-header flex-wrap">
                <div class="card-title">
                    @if (!isset($user['id']) || (isset($user['id']) && $user['id'] == ''))
                        <h3 class="card-label">{{ __('user.title_add_user', ['user_type' => $user_type]) }}</h3>
                    @else
                        <h3 class="card-label">{{ __('user.title_update_user', ['user_type' => $user_type]) }}</h3>
                    @endif
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.users', ['user_type' => $user_type]) }}"
                        class="btn btn-primary font-weight-bolder mr-2"><i class="fa fa-list"></i>
                        {{ __('user.title_users_list', ['user_type' => $user_type]) }}</a>
                    @if (isset($user['id']) && $user['id'])
                        <a href="{{ route('admin.adduser', ['user_type' => $user_type]) }}"
                            class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i>
                            {{ __('user.title_add_user', ['user_type' => $user_type]) }}</a>
                    @endif

                </div>
            </div>
            <!--End:: Card Header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <form id="user-form" ng-submit="saveUser()">
                            <input type="hidden" name="id" ng-model="user.id" />
                            <input type="hidden" name="user_type" value="{{ $user_type }}" />
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Country
                                        <required-span></required-span>
                                    </label>
                                    <select required class="form-control" ng-change="countryChange()" id="country"
                                        name="country" ng-model="user.country">
                                        <option disabled value="">Select Country</option>
                                        <?php foreach ($countries as $index => $each_country) {
                                            echo "<option value='" . $index . "'>" . $each_country . '</option>';
                                        } ?>

                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Full Name <span class="text-danger">*</span></label>
                                    <input required type="text" ng-model="user.name" class="form-control d-none"
                                        name="first_name" placeholder="Enter First Name" />

                                    <input required type="text" ng-model="user.name" class="form-control" name="name"
                                        placeholder="Enter Name" />
                                </div>
                                <div class="col-md-3 form-group d-none">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" ng-model="user.last_name" name="last_name"
                                        placeholder="Enter Last Name" />
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" ng-model="user.email" name="email"
                                        placeholder="Enter Email" />
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>Phone <span class="text-danger d-none">*</span></label>
                                    {{-- @{{ user.country_ext | json }} --}}
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="form-control" id="country_ext" name="country_ext"></select>
                                        </div>
                                        <input maxlength="10" type="text" class="form-control" ng-model="user.mobile1"
                                            name="mobile1" placeholder="Enter Mobile1" />
                                    </div>

                                </div>
                                <div ng-show="showMobile2" class="col-md-3 form-group">
                                    <label>Mobile2</label>
                                    <input type="text" maxlength="10" class="form-control" ng-model="user.mobile2"
                                        name="mobile2" placeholder="Enter Mobile2" />
                                </div>

                                <div ng-show="showUsername" class="col-md-3 form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" ng-model="user.username" name="username"
                                        placeholder="Enter Username" />
                                </div>
                                @yield('role_input')
                                <div class="col-md-4 form-group">
                                    {{-- <div class="col-md-3 form-group" ng-show="user.role_id!='<?php echo ROLE_CUSTOMER; ?>'"> --}}
                                    <label>Password <span class="text-danger d-none">*</span> <span style="font-size: 8px;"
                                            ng-show="user.id" class="text-warning d-none">
                                            (Password can not be shown due to
                                            encryption.)</span>
                                    </label>
                                    <input type="text" class="form-control" ng-model="user.password" name="password"
                                        placeholder="Enter Password" />
                                    <label ng-show='user.id' class="checkbox checkbox-round mt-2">
                                        <input ng-model='user.update_password' ng-cheked='user.update_password==1'
                                            ng-true-value='1' ng-false-false='0' type="checkbox" class="select_all_ids"
                                            value="1">
                                        <span></span>
                                        &nbsp;Update password
                                    </label>
                                </div>
                                <div class="col-md-3 form-group d-none">
                                    <label>State
                                        <required-span></required-span>
                                    </label>
                                    <select class="form-control" name="state" id="state" ng-model="user.state">
                                        <option value="">Select State</option>
                                        <option ng-repeat="(stateCode,stateName) in states"
                                            value="@{{ stateCode }}">
                                            @{{ stateName }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group d-none">
                                    <label>City</label>
                                    <input type="text" name="city" ng-model="user.city" placeholder="Enter city"
                                        class="form-control" />
                                </div>
                                <div class="col-md-3 form-group d-none">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" ng-model="user.pincode"
                                        placeholder="Enter pincode" class="form-control" />
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select required class="form-control" name="status" ng-model="user.status">
                                        <option disabled value="">-- Select --</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12 form-group d-none">
                                    <label>Address Line 1</label>
                                    <textarea class="form-control" name="address_line1" ng-model="user.address_line1"
                                        placeholder="Enter Address Line 1"></textarea>
                                </div>
                                <div ng-show="showAddressLine2" class="col-md-12 form-group">
                                    <label>Address Line 2</label>
                                    <textarea class="form-control" name="address_line2" ng-model="user.address_line2"
                                        placeholder="Enter Address Line 2"></textarea>
                                </div>

                                <div ng-if="user.profile_picture" class="col-md-1 form-group">
                                    <img class="img-fluid" ng-src="@{{ user.profile_picture }}" alt="image">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>Profile Image</label>
                                    <input class="form-control" type="file" id="fileInput" name="fileInput"
                                        accept=".jpg,.jpeg,.png">
                                </div>


                                @yield('user_form_end_extend')


                                <div class="col-md-12">
                                    <button type="submit"
                                        class="btn btn-primary spinner-white spinner-right submit-button font-weight-bolder">
                                        <?php echo isset($user['id']) && $user['id'] ? 'Update' : 'Add'; ?></button>
                                    <button type="reset" class="btn btn-secondary font-weight-bolder">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @push('scripts')
            {{ \App\Http\Controllers\Admin\Locations\LocationSupports::get_country_states_js() }}
            <script>
                var userForm = $('#user-form');
                var submitButtonClass = '.submit-button';
                var stateEl = $('#state');
                var countryEl = $('#country');
                var countryExtEl = $('#country_ext');

                //getPostScreenAngularScrope
                // return scope of post screen controller
                function getUserScreenAngularScope() {
                    return angular.element($("#user-controller")).scope();
                }

                angularApp.controller('user-controller', function($scope) {
                    // vars for hide and show fields
                    $scope.showMobile2 = false;
                    $scope.showUsername = false;
                    $scope.showAddressLine2 = false;

                    // user details
                    $scope.user = @JSON($user);
                    $scope.holdUser = @JSON($user);
                    // user role list
                    $scope.user_roles = @JSON($users_roles);
                    // state list
                    $scope.states = @json($states);
                    // set a default role
                    if (typeof $scope.user.role_id == "undefined" || $scope.user.role_id == null || $scope.user.role_id ==
                        "") {
                        $scope.user.role_id = "";
                    }
                    if (typeof $scope.user.user_meta_data == "undefined" || $scope.user.user_meta_data == null) {
                        $scope.user.user_meta_data = {};
                    }

                    angular.element(document).ready(function() {
                        // set fields
                        $scope.user.country = "{{ \App\Http\Controllers\Bz::getDefaultCountryCode() }}";
                        $scope.user.password = "";
                        countryEl.triggerHandler('change');
                        $scope.countryChange();
                        bindAjs($scope);
                        bindAjs($scope.$parent);
                    });
                    $scope.countryChange = function() {
                        // do reset states
                        $scope.states = [];
                        countryExtEl.html('');
                        getCountryStates($scope.user.country, $scope.getCountryStates);
                    }
                    // getCountryStates
                    $scope.getCountryStates = function(response) {
                        $scope.states = response.data.states_list;
                        countryExtEl.html(response.data.country_phone_code_list_html);
                        $scope.user.state = $scope.holdUser.state;
                        bindAjs($scope);
                        // set first country ext
                        $scope.user.country_ext = "";
                        $scope.user.country_ext = $('#country_ext').find(":selected").val();
                    }

                    // save user
                    $scope.saveUser = function() {
                        event.preventDefault();
                        // Create a new FormData object
                        var formData = new FormData();
                        // Append the file to the FormData object
                        formData.append('fileInput', $('#fileInput')[0].files[0]);
                        // Append other data to the FormData object if needed
                        formData.append('user', JSON.stringify($scope.user));
                        $.ajax({
                            type: 'post',
                            url: '{{ route('admin.api.createUser') }}',
                            dataType: 'json',
                            data: formData,
                            async: false,
                            cache: false,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function() {
                                userForm.find(submitButtonClass).addClass('spinner');
                            },
                            success: function(response) {
                                show_html_error(response);
                                userForm.find(submitButtonClass).removeClass('spinner');
                                if (response.succ) {
                                    setTimeout(function() {
                                        window.location.href = response.data.redirect;
                                    }, 1000);
                                }
                                bindAjs($scope);
                            }
                        });
                    }
                });
            </script>
        @endpush
    @endsection
