<style>
    .widget-box {
        text-align: center;
        background: #fff;
        border: 5px solid #5dcdc6;
        padding: 10px;
        border-radius: 5px;
    }

    .widget-box h3 {
        margin: 0 auto;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .widget-box p {
        font-size: 16px;
    }

    .widget-box a {
        color: inherit;
        display: flex;
        align-items: center;
    }
</style>

<div class="card card-custom gutter-b">
    <div class="card-header border-0 align-items-center">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">System overview</span>
        </h3>
        <div class="card-toolbar d-none">
            <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                <li class="nav-item">
                    <a class="btn btn-primary font-weight-bolder" href="#">View All</a>

                </li>
            </ul>
        </div>
    </div>
    <div class="card-body card-body pt-2 pb-0 mt-n3">
        <div class="card-spacer" style="padding: 0 !important;">
            <!--begin::Row-->
            @if (count($dashboard_widgets))
                <div class="row">
                    @foreach ($dashboard_widgets as $dashboard_widget)
                        <div class="col-md-3 mb-5">
                            <div class="bg-light-primary px-6 py-8 rounded-xl">
                                <h3 class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                    {{ $dashboard_widget['value'] }}
                                </h3>
                                <a href="{{ $dashboard_widget['link'] }}"
                                    class="text-primary font-weight-bold font-size-h6">{{ $dashboard_widget['title'] }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @php
        do_action('dashboard_widgets_content');
    @endphp
</div>
