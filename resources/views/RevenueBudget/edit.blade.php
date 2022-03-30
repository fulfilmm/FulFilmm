@extends('layout.mainlayout')
@section('title','Revenue Budget Edit')
@section('content')
    <!-- Page Content -->

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add New Revenue Budget</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add New Revenue Budget</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <form action="{{route('revenuebudget.update',$revenue_budget->id)}}" method="post">
                    <div class="card-header"><button type="submit" class="btn btn-primary"><i class="la la-save"></i>Update</button></div>
                    <div class="col-12 my-3">

                        @csrf
                        @method("PUT")
                        <div class="col-6 offset-3">
                            <div class="form-group">
                                <label for="">Budget Name</label>
                                <input type="text" class="form-control" name="name" value="{{$revenue_budget->name}}">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" name="year" value="{{$revenue_budget->year}}">
                            </div>
                        </div>
                        <div class="col-12" style="overflow: auto">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th style="min-width: 200px">Description</th>
                                    <th style="min-width: 150px">Cost Center</th>
                                    <th style="min-width: 150px;">Department</th>
                                    <th style="min-width: 150px;">Total</th>
                                    <th style="min-width: 150px;">Jan</th>
                                    <th style="min-width: 150px;">Feb</th>
                                    <th style="min-width: 150px;">Mar</th>
                                    <th style="min-width: 150px;">Apr</th>
                                    <th style="min-width: 150px;">May</th>
                                    <th style="min-width: 150px;">Jun</th>
                                    <th style="min-width: 150px;">Jul</th>
                                    <th style="min-width: 150px;">Aug</th>
                                    <th style="min-width: 150px;">Sep</th>
                                    <th style="min-width: 150px;">Oct</th>
                                    <th style="min-width: 150px;">Nov</th>
                                    <th style="min-width: 150px;">Dec</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->coa->code}}</td>
                                        <td>{{$item->coa->name}}</td>
                                        <td><input type="text" class="form-control" name="cost_center[{{$item->id}}]" placeholder="Enter Cost Center" value="{{$item->cost_center}}"></td>
                                        <td><input type="text" class="form-control" name="dept[{{$item->id}}]" placeholder="Department" value="{{$item->department}}"></td>
                                        <td><input type="text" class="form-control" name="total[{{$item->id}}]" id="total_{{$item->id}}" placeholder="Total" readonly="" value="{{$item->total}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jan[{{$item->id}}]" placeholder="Jan" value="{{$item->jan}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="feb[{{$item->id}}]" placeholder="Feb" value="{{$item->feb}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="mar[{{$item->id}}]" placeholder="Mar" value="{{$item->mar}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="apr[{{$item->id}}]" placeholder="Apr" value="{{$item->apr}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="may[{{$item->id}}]" placeholder="May" value="{{$item->may}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jun[{{$item->id}}]" placeholder="Jun" value="{{$item->jun}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jul[{{$item->id}}]" placeholder="Jul" value="{{$item->jul}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="aug[{{$item->id}}]" placeholder="Aug" value="{{$item->aug}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="sep[{{$item->id}}]" placeholder="Sep" value="{{$item->sep}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="oct[{{$item->id}}]" placeholder="Oct" value="{{$item->oct}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="nov[{{$item->id}}]" placeholder="Nov" value="{{$item->nov}}"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="dec[{{$item->id}}]" placeholder="Dec" value="{{$item->dec}}"></td>
                                        <script>
                                            $('.estimate_{{$item->id}}').keyup(function () {
                                                var sum = 0;
                                                $('.estimate_{{$item->id}}').each(function() {
                                                    var val=$(this).val();

                                                    if(val!==''){
                                                        sum += parseFloat(val);
                                                    }

                                                });
                                                $('#total_{{$item->id}}').val(sum);
                                            });
                                        </script>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection