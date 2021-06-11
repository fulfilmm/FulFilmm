@extends("layout.mainlayout")
@section("title","Doughnut Chart Report")
@section("content")
{{--    @dd($priority)--}}
    <style>
        .chartjs-render-monitor{
            position:relative;
            padding-right: 20px;
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Chart Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chart</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <form action="{{url("/search")}}" method="POST" class="navbar-form my-3 mx-3">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group ml-3">
                                <input type="date" name="start_date" id="start_date" autocomplete="off" class="form-control" placeholder="Enter Start Date">
                            </div>
                            <div class="form-group ml-3 " >
                                <input type="date" name="end_date" id="end_date" autocomplete="off" class="form-control" placeholder="Enter End Date">
                            </div>
                            <div class="form-group ml-3">
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa fa-search mr-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
        <div class="row">
            <div class="col-md-4 offset-md-1 col-10 offset-1 text-center">
                <div class="card-header-pills">
                    <h4> Doughnut Chart By Status</h4>
                </div>
            </div>
            <div class="col-md-4 offset-md-1 col-10 offset-1 text-center">
                <div class="card-header-pills">
                    <h4>Doughnut Chart By Priority Type</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 offset-md-1 col-10 offset-1 text-center" >
                <div style="width:350px;height:250px;padding-left: 15px;" class="offset-md-1 col-sm-12 offset-sm-0 mt-3 mb-3">
                    <canvas id="status"></canvas>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 offset-md-1 col-10 offset-1 text-center" >
                <div style="width:250px;height:250px;padding-left: 15px;" class="offset-md-1 col-sm-12 offset-sm-0 mt-3 mb-3">
                    <canvas id="priority" ></canvas>
                </div>
            </div>
        </div>
    </div>
    {{--    @dd($priority);--}}
    <script>
        $(function () {
            var ctx = document.getElementById("priority").getContext('2d');
            var data = {
                datasets: [{
                    data: [
                        {{$priority['Urgent']}},
                        {{$priority['High']}},
                        {{$priority['Medium']}},
                        {{$priority['Low']}}
                    ],
                    backgroundColor: [
                        '#ef0636',
                        '#9605a0',
                        '#4642ea',
                        "#6fe00b"
                    ],
                }],
                labels: [
                    'Urgent',
                    'High',
                    'Medium',
                    'Low'
                ]
            };
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    maintainAspectRatio: false,
                    // title:{
                    //     display:true,
                    //     text:"All Ticket's Priority Doughnut Chart"
                    // },
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                }
            });

            var ctx_2 = document.getElementById("status").getContext('2d');
            var data_2 = {
                datasets: [{
                    data: [
                        "{{$statuses["New"]}}",
                        {{$statuses["Open"]}},
                        {{$statuses["Close"]}},
                        {{$statuses["Pending"]}},
                        {{$statuses["Progress"]}},
                        {{$statuses["Complete"]}}
                    ],
                    backgroundColor: [
                        '#5B7656FF',
                        '#7c0aa5',
                        '#0b43ee',
                        '#f8f159',
                        "#50d007",
                        "#f30d3b",
                    ],
                }],
                labels: [
                    'New',
                    'Open',
                    'Pending',
                    'Progress',
                    'Complete',
                    'Close'
                ]
            };
            var myDoughnutChart_2 = new Chart(ctx_2, {
                type: 'doughnut',
                data: data_2,
                options: {
                    maintainAspectRatio: false,
                    // title:{
                    //     display:true,
                    //     text:"All Ticket's Status Doughnut Chart"
                    // },
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                }
            });
        });
    </script>
@endsection
