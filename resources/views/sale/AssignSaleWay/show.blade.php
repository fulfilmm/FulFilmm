@extends('layout.mainlayout')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">View Sales Ways</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">View Sales Ways</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-12">
                        <div id="map" class="shadow" style="width: 700px; height: 500px;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-12">
                        <span><strong>Way Id </strong>:{{$assignway->way->way_id}}</span><br>
                        <span><strong>Way Name</strong> :{{$assignway->way->name}}</span><br>
                        <span><strong>Group</strong> :{{$assignway->group->name}}</span><br>
                        <span><strong>Shop List</strong> </span>
                        <ul style="list-style-type:number">
                            @foreach($shop as $item)
                                <form action="{{route('check',$item->id)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="emp_location" id="emp_location{{$item->id}}">
                                    <li class="mb-3">{{$item->shop->name}} <i
                                                class="la la-{{$item->reach?'check':''}}"></i>
                                        <button type="submit"
                                                class="btn btn-outline-success btn-sm float-right rounded-pill"
                                                style="font-size: 10px;">Checkin
                                        </button>

                                    </li>
                                    <script>
                                        $(document).ready(function () { //user clicks button
                                            if ("geolocation" in navigator) { //check geolocation available
                                                //try to get user current location using getCurrentPosition() method
                                                navigator.geolocation.getCurrentPosition(function (position) {
                                                    $("#emp_location{{$item->id}}").val(position.coords.latitude + ',' + position.coords.longitude);
                                                });
                                            } else {
                                                console.log("Browser doesn't support geolocation!");
                                            }
                                        });
                                    </script>
                                </form>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
    <script>

        $(document).ready(function () {
            $('select').select2();
        });
        $(function () {
            $("#map").googleMap();

            // Marker 1
            {{--          @if(\Illuminate\Support\Facades\Auth::guard('employee')->user->role->name=='Sale Manager')--}}
            @foreach($shop as $item)
            $("#map").addMarker({
                title: '<span style="font-size: 14px;">{{$item->shop->name}}</span>', // Title
                text: '<span>Contact Person: {{$item->shop->contact}}</span><br><span>Phone :{{$item->shop->phone}}</span>',
                coords: [{{$item->shop->location}}]
            });
            @endforeach
            @foreach($shop as $item)
                @if($item->reach)
            $("#map").addMarker({
                title: '<span style="font-size: 14px;">Employee Checkin Location for ({{$item->shop->name}})</span>', // Title
                text: '<span>Contact Person: {{$item->shop->contact}}</span><br><span>Phone :{{$item->shop->phone}}</span>',
                coords: [{{$item->emp_location}}]
            });
                @endif
            @endforeach
            {{--@else--}}

            {{--@endif--}}
        });
    </script>
    <!-- /Page Wrapper -->

@endsection