        <div class="card-header border-0 align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">New Users</span>
            </h3>
            <div class="card-toolbar">
                <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                    <li class="nav-item">
                        <a class="btn btn-primary font-weight-bolder"
                            href="{{ route('admin.users', ['user_type' => 'user']) }}">View All</a>
                        {{-- <a class="nav-link py-2 px-4 active btn btn-primary font-weight-bolder"  href="{{ route('admin.documents') }}">View All</a> --}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body pt-2 pb-0 mt-n3">
            <div class="row">
                @foreach ($users as $user)
                    @php
                        $user_profile_url = route('user.view_profile', ['user_type' => 'user', 'user_id' => $user['id']]);
                        // $user_profile_url = route('admin.editUser', ['user_type' => 'user', 'user_id' => $user['id']]);
                    @endphp
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body pt-4">
                                <!--begin::User-->
                                <div class="d-flex align-items-end mb-7">
                                    <!--begin::Pic-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Pic-->
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-circle symbol-lg-75">
                                                <img src="{{ $user->profile_img }}" alt="image">
                                            </div>
                                            <div class="symbol symbol-lg-75 symbol-circle symbol-primary d-none">
                                                <span class="font-size-h3 font-weight-boldest">JM</span>
                                            </div>
                                        </div>
                                        <!--end::Pic-->
                                        <!--begin::Title-->
                                        <div class="d-flex flex-column">
                                            <a href="{{ $user_profile_url }}"
                                                class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{ $user->name }}</a>
                                            <span class="text-muted font-weight-bold">{{ $user->role->role }}</span>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::User-->
                                <!--begin::Desc-->
                                {{-- <p class="mb-7">
                                I distinguish three <a href="#" class="text-primary pr-1">#XRS-54PQ</a> objectives
                                First
                                objectives and nice cooked rice
                            </p> --}}
                                <!--end::Desc-->
                                <!--begin::Info-->
                                <div class="mb-7">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Email:</span>
                                        <a href="mailto:{{ $user->email }}"
                                            class="text-muted text-hover-primary">{{ $user->email }}</a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-cente my-1">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Phone:</span>
                                        <a href="tel:{{ $user->formatted_mobile }}"
                                            class="text-muted text-hover-primary">{{ $user->formatted_mobile }}</a>
                                    </div>
                                </div>
                                <!--end::Info-->
                                <a href="{{ $user_profile_url }}"
                                    class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4">View
                                    Details</a>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                @endforeach
            </div>
        </div>