<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget shadow">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-group"></i></span>
                <div class="dash-widget-info">
                    <h3>{{$items['my_groups']}}</h3>
                    <span>My Groups</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{url('sale/activity')}}">
            <div class="card dash-widget shadow">
                <div class="card-body">
                                <span class="dash-widget-icon"><img
                                            src="{{url(asset('img/profiles/saleactivity.png'))}}" alt="" width="30"
                                            height="30"></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['saleactivity']}}</h3>
                        <div class="row">
                            <span>Sale Activity</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('meetings.index')}}">
            <div class="card dash-widget shadow">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-calender"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['meeting']}}</h3>
                        <span>Meeting</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <a href="{{route('meetings.index')}}">
            <div class="card dash-widget shadow">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-money"></i></span>
                    <div class="dash-widget-info">
                        <h3>{{$items['assignment']??0}}</h3>
                        <span>Assignment</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>