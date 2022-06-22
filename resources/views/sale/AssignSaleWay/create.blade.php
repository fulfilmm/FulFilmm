@extends('layout.mainlayout')
@section('title','Assign Sale Ways')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Sales Ways</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Sales Ways</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow">
                @error('branch_id')
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>You did not connect any office branch!</strong>
                    @enderror
                </div>

                <div class="col-12">
                    <form action="{{route('assignsaleway.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="branch">Branch</label>
                            <select name="branch_id" id="" class="form-control" style="width: 100%">
                                @foreach($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id">Way ID</label>
                            <select name="way_id" id="id" class="form-control">
                                @foreach($ways as $way)
                                    <option value="{{$way->id}}">{{$way->way_id}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="radio" name="type" value="1" checked> Group Assign
                            <input type="radio" name="type" value="0"> Individual Assign
                        </div>
                        <div class="form-group" id="group_div">
                            <label for="group">Group</label>
                            <select name="group_id" id="shop" class="form-control" >
                                @foreach($groups as $gp)
                                    <option value="{{$gp->id}}">{{$gp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="emp_div">
                            <label for="group">Employee</label>
                            <select name="emp_id[]" id="shop" class="form-control" >
                                @foreach($employees as $emp)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start">Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{\Carbon\Carbon::today()->addDay(1)->format('Y-m-d')}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('select').select2();
                $('#emp_div').hide();
                $("input[name='type']").click(function () {
                    var type=$("input[name='type']:checked").val();
                    if(type==1){
                        $('#group_div').show();
                        $('#emp_div').hide();
                    }else {
                        $('#emp_div').show();
                        $('#group_div').hide()
                    }
                });


            });
        </script>
    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection