@extends($themeLayoutPath)
@section('menu_title')
    Users
@endsection
@section('content')
    <div class="container">
        <div class="card card-custom gutter-b">
            <!--begin:: Card Header -->
            <div class="card-header flex-wrap">
                <div class="card-title">
                    <h3 class="card-label">
                        {{ __('user.title_users_list', ['user_type' => $user_type]) }}
                        {{-- <span class="d-block text-muted pt-2 font-size-sm">User management made easy</span> --}}
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.adduser', ['user_type' => $user_type]) }}"
                        class="btn btn-primary font-weight-bolder">
                        <i class="fa fa-plus"></i> {{ __('user.title_add_user', ['user_type' => $user_type]) }}
                    </a>
                </div>
            </div>
            <!--End:: Card Header -->
            <div class="card-body">
                <form id="user-filter-form" class="user-filter-form" action="" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="">Search by keyword</label>
                            <input type="text" value="{{ request()->get('search') }}" class="form-control" name="search"
                                placeholder="Name,email,mobile" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="Select by date">
                                <div class="d-flex ">
                                    <input value="1" {{ request()->get('filter_date') == 1 ? 'checked' : '' }}
                                        type="checkbox" name="filter_date" class="mr-1">
                                    Search by date
                                </div>
                            </label>
                            <input name="registered_at" class="daterange-registered-date form-control"
                                value="{{ request()->get('registered_at') }}" />
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="">Status</label>
                            <select class="form-control" name="status">
                                <option {{ request()->get('status') == '' ? 'selected' : '' }} value="">-- All --
                                </option>
                                <option value="1" {{ request()->get('status') === '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ request()->get('status') === '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 form-group d-none">
                            <label for="">Role</label>
                            <select class="form-control" name="role_id">
                                <option value="">-- All --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role['role_id'] }}" <?php echo @$_GET['role_id'] == $role['role_id'] ? 'selected' : ''; ?>>{{ $role['role'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Sort</label>
                            <select class="form-control" name="sort">
                                <option value="">Default</option>
                                @foreach (\App\Models\UserModel::getUserFilterSortings() as $sorting)
                                    <option {{ request()->get('sort') == $sorting['value'] ? 'selected' : '' }}
                                        value="{{ $sorting['value'] }}">{{ $sorting['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group d-none">
                            <label>Country</label>
                            <select id="country" class="form-control" onchange="countryChange()" name="country">
                                <option value="">All</option>
                                <?php foreach (get_countries_list() as $index => $each_country) {
                                    echo "<option value='" . $index . "'>" . $each_country . '</option>';
                                } ?>

                            </select>
                        </div>
                        <div class="col-md-2 form-group d-none">
                            <label>State</label>
                            <select class="form-control" id="state" name="state">
                                <option value="">All</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="font-weight-bolder" style="visibility: hidden;">Submit</label>
                            <div>
                                <button type="submit" class="btn btn-primary font-weight-bolder">Search</button>
                                <button onclick="window.location.href='<?php echo route('admin.users', ['user_type' => 'user']); ?>';" type="button"
                                    class="btn btn-secondary font-weight-bolder">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 form-group">
                        <div class="table-responsive">
                            <table class="table admin-post-listing-table">
                                <caption style="caption-side:top;">
                                    @include('admin.global.showing-from-to-result', [
                                        'results' => $results,
                                    ])
                                </caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>VAT No.</th>
                                        <th>Status</th>
                                        <th>Activity At</th>
                                        <th>Docs.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $key => $user)
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold text-muted">
                                                    {{ $results->firstItem() + $key }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                    <div class="symbol symbol-circle symbol-lg-50">
                                                        <img src="{{ $user['profile_img'] }}" alt="image">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->role->role }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->formatted_mobile }}</td>
                                            <td>{{ $user->meta_data['vat_number']??'' }}</td>
                                            <td>
                                                @if ($user['status'] == 0)
                                                    <span
                                                        class="label label-lg font-weight-bold  label-light-danger label-inline">{{ mk_display_user_status($user['status']) }}</span>
                                                @endif
                                                @if ($user['status'] == 1)
                                                    <span
                                                        class="label label-lg font-weight-bold  label-light-primary label-inline">{{ mk_display_user_status($user['status']) }}</span>
                                                @endif

                                            </td>
                                            <td>
                                                <p class="mb-0"><b>Registered:</b>
                                                    @if (isset($user->created_at) && $user->created_at)
                                                        {{ date('d-m-Y h:i:s A', strtotime($user->created_at)) }}
                                                    @endif
                                                </p>
                                                <p class="mb-0">
                                                    <b>Last Login:</b>
                                                    @if (isset($user->meta_data['last_login_at']) && $user->meta_data['last_login_at'])
                                                        {{ date('d-m-Y h:i:s A', strtotime($user->meta_data['last_login_at'])) }}
                                                        @else
                                                        <span class="text-danger">Not logged in yet</span>
                                                    @endif
                                                </p>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.documents', ['user_id' => $user->id]) }}">
                                                    {{ App\plugins\documentsManager\Controllers\DocumentManagerController::getAllDocuments(['user_id' => $user->id])->total() }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="dropdown dropdown-inline">
                                                    <a href="{{ route('admin.editUser', ['user_type' => $user_type, 'user_id' => $user['id']]) }}"
                                                        class="btn btn-sm btn-clean btn-icon mr-2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a target="_blank"
                                                        href="{{ route('user.view_profile', ['user_id' => $user['id']]) }}"
                                                        class="btn btn-sm btn-clean btn-icon mr-2">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    @php
                                                        $showDelBtn = true;
                                                        $admin_user = get_option_value('global_admin_user_id');
                                                        if ($admin_user && $user->id == $admin_user) {
                                                            $showDelBtn = false;
                                                        } else {
                                                            $showDelBtn = true;
                                                        }
                                                    @endphp

                                                    @if ($showDelBtn)
                                                        <a onclick="deleteUser(this)"
                                                            href="{{ route('admin.deleteUser', ['user_type' => $user_type, 'user_id' => $user['id']]) }}"
                                                            class="btn btn-sm btn-clean btn-icon mr-2">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (!$results->count())
                                        <tr>
                                            <td>{{ __('common.data_list_empty') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($results->hasPages())
                            <div class="col-md-12 mk-custom-pagination">
                                <div class="pagination-wrapper">
                                    {{ $results->appends(request()->query())->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const queryString = window.location.search;
            // Create a URLSearchParams object from the query string
            const params = new URLSearchParams(queryString);
            // Access individual parameters using the get() method
            const registered_at = params.get('registered_at');
            let fromDate = null;
            let toDate = null;
            if (registered_at) {
                fromDate = (registered_at.split('to')[0]).trim();
                toDate = (registered_at.split('to')[1]).trim();
            }
        </script>
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" />
        <script>
            // init
            var currentDate = new Date();
            // Set the start date to the first day of the current month
            var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            // Set the end date to the last day of the current month
            var endDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            $('.daterange-registered-date').daterangepicker({
                timePicker24Hour: false,
                timePickerSeconds: false,
                startDate: fromDate ? moment(fromDate) : moment(startDate),
                endDate: toDate ? moment(toDate) : moment(endDate),
                locale: {
                    format: "YYYY-MM-DD",
                    separator: " to ",
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, function(start, end, label) {

            });
        </script>
        <?php echo \App\Http\Controllers\Admin\Locations\LocationSupports::get_country_states_js(); ?>
        <script>
            var filterFormName = "user-filter-form";
            var filterForm = $("#" + filterFormName);

            /**
             * Handler for export current screen data
             */
            function exportResults() {
                let confirmMsg = confirm("Sure want to export listed results?");
                if (!confirmMsg) {
                    return false;
                }
                let oldAction = filterForm.attr('action');
                let formActionURL = "{{ route('users.export') }}";
                event.preventDefault();
                filterForm.attr('action', formActionURL);
                setTimeout(function() {
                    filterForm.trigger('submit');
                    filterForm.attr('action', oldAction);
                });
            }
        </script>

        <script>
            var requestData = @json($_GET);
            var stateEl = $('#state');
            var countryEl = $('#country');
            var isReadyStateForCountryManage = true;
            // on ready state
            $(document).ready(function() {
                if (typeof requestData.country != "undefined" && requestData.country) {
                    countryEl.val(requestData.country).trigger('change');
                }
            });

            var allStatesOptionHtml = '<option value="">All States</option>';

            function countryChange() {
                let selectedCountry = countryEl.val();
                // do reset
                stateEl.html(allStatesOptionHtml);
                if (selectedCountry) {
                    getCountryStates(selectedCountry, getCountryStatesCallback);
                }
            }

            // getCountryStates
            function getCountryStatesCallback(response) {
                stateEl.html(allStatesOptionHtml + response.data.states_list_options_html);
                setTimeout(function() {
                    if (isReadyStateForCountryManage) {
                        // set customer's state
                        stateEl.val(requestData.state); // set state
                    }
                    isReadyStateForCountryManage = false;
                }, 500);
            }


            /*
            deleteUser
            Delete user
            */
            function deleteUser(that) {
                event.preventDefault();
                let confirmDel = confirm("{{ __('common.sure_want_to_delete') }}");
                if (confirmDel) {
                    window.location.href = $(that).attr('href');
                } else {
                    return false;
                }
            }
        </script>
    @endpush
@endsection
