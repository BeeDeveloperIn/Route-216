@extends($themeLayoutPath)
@section('menu_title')
    Manage profile
@endsection
@section('content')
    <div class="container" ng-controller="userController" id="userController" ng-cloak='Processing..'>
        <!--begin::Profile Change Password-->
        <div class="d-flex flex-row">
            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">
                        <!--begin::User-->
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url('{{ $userData->profile_img }}')">
                                </div>
                                <i class=" symbol-badge bg-success"></i>
                            </div>
                            <div>
                                <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">
                                    {{ $userData->name }}</a>
                                <div class="text-muted">{{ $userData->role->role }}</div>
                            </div>
                        </div>
                        <!--end::User-->
                        <!--begin::Contact-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Email:</span>
                                <a href="mailto:{{ $userData->email }}"
                                    class="text-muted text-hover-primary">{{ $userData->email }}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Phone:</span>
                                <span class="text-muted">{{ $userData->formatted_mobile }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Status:</span>
                                <span class="text-muted">{{ $userData->block_status_text }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <span class="font-weight-bold mr-2">Action:</span>
                                <span class="text-muted">
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.editUser', ['user_type' => 'user', 'user_id' => $userData['id']]) }}">Edit
                                        Profile</a>
                                </span>
                            </div>
                            @if(count($folders) > 0)
                            <hr/>
                            <div class="mt-5">
                                <h5 class="font-weight-bold mr-2">Custom Folders:</h5>
                               @foreach($folders as $folder)
                                <button class="btn-sm border border-1 rounded-pill mt-2"> <i class="fa fa-folder"></i>&nbsp;{{ $folder->title}}<a onclick="deleteFolder(this)" href="{{route('admin.deleteFolder',['folder_id' => $folder->id])}}"> <i class="fa fa-times" style="color:red;"></i></a></button>
                               @endforeach
                            </div>
                            @endif

                        </div>
                        <!--end::Contact-->
                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded d-none">
                            <div class="navi-item mb-2">
                                <a ng-click="changeAccountScreen('profile-info')"
                                    ng-class="{'active': tab==='profile-info'}" href="javascript:void(0)"
                                    class="navi-link py-4">
                                    <span class="navi-icon mr-2">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo9/dist/assets/media/svg/icons/General/User.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path
                                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    <path
                                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                                        fill="#000000" fill-rule="nonzero"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text font-size-lg">Personal Information</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->
            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->

                <div ng-if="tab=='profile-info'">
                    <div class="card card-custom mb-5">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Recent Activities</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Recently actions & events
                                    performed by {{ $userData->name }}</span>
                            </div>

                            <div class="card-toolbar">
                                <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                    @if (!empty($logs) && $logs->hasPages())
                                        <li class="nav-item">
                                            <a class="btn btn-primary py-2 px-4" href="{{ $view_all_logs_url }}">View
                                                All</a>
                                        </li>
                                    @endif

                                </ul>
                            </div>


                        </div>
                        <div class="card-body">

                            @if (!empty($logs) && $logs->count())
                                @foreach ($logs as $i => $log)
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center {{ $i != 0 ? 'mt-10' : '' }} ">
                                        <!--begin::Bullet-->
                                        <span class="bullet bullet-bar bg-success align-self-stretch"></span>
                                        <!--end::Bullet-->

                                        <!--begin::Checkbox-->
                                        <label
                                            class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                                            {{-- <input type="checkbox" name="select" value="1"> --}}
                                        </label>
                                        <!--end::Checkbox-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column flex-grow-1">
                                            <a href="#"
                                                class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">
                                                {{ $log->log }}
                                            </a>
                                            <span class="text-muted font-weight-bold">
                                                {{ date('d-M-Y h:i:s A', strtotime($log->created_at)) }}
                                            </span>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end:Item-->
                                @endforeach
                            @else
                                <p class="text-warning ">
                                    There is no activity found
                                </p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Profile Change Password-->
    </div>
@endsection
@push('scripts')
    <?php
    if (get_current_user_id()){
        ?>
    <script type="text/javascript">
        var submitButtonClass = '.submit-button';
        angularApp.controller('userController', function($scope, $http) {
            $scope.tab = "profile-info";
            $scope.userData = @json($userData); // user data

            // Update self details
            $scope.changeSelfProfile = function() {
                event.preventDefault();
                let profileForm = $("#changeSelfProfileForm");
                $.ajax({
                    type: 'post',
                    url: '<?php echo route('users.updateSelfProfile'); ?>',
                    dataType: 'json',
                    data: profileForm.serialize(),
                    beforeSend: function() {
                        profileForm.find(submitButtonClass).addClass('spinner');
                    },
                    success: function(response) {
                        show_html_error(response);
                        profileForm.find(submitButtonClass).removeClass('spinner');
                        if (response.succ) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 500);
                        }
                        bindAjs($scope);
                    }
                });
            }
            $scope.changeAccountScreen = function(screen) {
                $scope.tab = screen;
            }

            // Change current user profile picture
            $scope.changeProfilePicture = function() {
                event.preventDefault();
                var formData = new FormData($('#updatePicture')[0]);
                let profileForm = $('#updatePicture');
                $.ajax({
                    url: '{{ route('users.updateProfileImage') }}',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function() {
                        profileForm.find(submitButtonClass).addClass('spinner');
                    },
                    success: function(response) {
                        show_html_error(response);
                        profileForm.find(submitButtonClass).removeClass('spinner');
                        if (response.succ) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                        bindAjs($scope);
                    }
                });
            }
        });

        /*
            deleteFolder
            Delete folder
        */
        function deleteFolder(that) {
            event.preventDefault();
            let confirmDel = confirm("{{ __('common.sure_want_to_delete') }}");
            if (confirmDel) {
                window.location.href = $(that).attr('href');
            } else {
                return false;
            }
        }
    </script>
    <?php
    }
    ?>
@endpush
