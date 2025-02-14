@extends($themeLayoutPath)
@section('menu_title')
    {{ $active_setting['section_heading'] }}
@endsection
@section('content')
    <div class="container" ng-controller="store-options">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ $active_setting['section_heading'] }}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <form id="options-form" ng-submit="insert_options_request()">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="example-preview">
                                        <div class="row">
                                            <div class="col-3">
                                                <ul class="nav flex-column nav-pills">
                                                    <li class="nav-item mb-2" ng-repeat="(key,section) in settings" ng-show='section.is_public'>
                                                        <a class="nav-link"
                                                           ng-class="{'active': section.is_active =='1'}"
                                                           href="@{{ section.url }}">
                                                            <span class="nav-text">@{{ section.section_heading }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-9">
                                                <div class="tab-content" id="myTabContent5">
                                                    <div class="tab-pane fade active show">
                                                        <div class="row">
                                                            <div class="col-md-12 form-group"
                                                                 ng-repeat="(optionKey,option) in options">
                                                                <label> @{{ option.label }}</label>
                                                                {{--                                                                //text--}}
                                                                <input ng-model="option.value"
                                                                       ng-show="option.type=='text'" type="text"
                                                                       class="form-control"
                                                                       placeholder="@{{ option.placeholder }}">

                                                                {{--                                                                // text area--}}
                                                                <textarea ng-model="option.value"
                                                                          ng-show="option.type=='textarea'"
                                                                          class="form-control"
                                                                          placeholder="@{{ option.placeholder }}"
                                                                >@{{ option.value }}</textarea>
                                                                {{--                                                                // select--}}
                                                                <select ng-model="option.value"
                                                                        ng-show="option.type=='select'"
                                                                        class="form-control">
                                                                    <option value="">--select--</option>
                                                                    <option ng-repeat="eachValue in option.options"
                                                                            value="@{{ eachValue.value }}"> @{{
                                                                        eachValue.title }}
                                                                    </option>
                                                                </select>

                                                            </div>
                                                            <div class="col-md-12 form-group">
                                                                <button
                                                                    class="btn btn-primary spinner-white spinner-right submit-button">{{ __('common.save_button_tax') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                angularApp.controller('store-options', function ($scope) {
                    $scope.settings = @json($settings);
                    $scope.options = @json($active_setting['options']);
                    console.log('$scope.options', $scope.options);
                    bindAjs($scope);


                    //insert_options_request
                    $scope.insert_options_request = function () {
                        event.preventDefault();
                        bindAjs($scope);
                        setTimeout(() => {
                            let dataFrom = $("#options-form");
                            let submitButtonClass = '.submit-button';
                            $.ajax({
                                url: '{{ route('admin.api.insert_options_request') }}',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    options: $scope.options
                                },
                                beforeSend: function () {
                                    dataFrom.find(submitButtonClass).addClass('spinner');
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    dataFrom.find(submitButtonClass).removeClass('spinner');
                                    show_html_error(response);
                                    if (response.succ) {
                                        setTimeout(() => {
                                            window.location.reload();
                                        },1000);
                                    }
                                    bindAjs($scope);
                                }
                            })
                        });
                    }

                });
            </script>
    @endpush
@endsection
