@extends('layout.mainlayout')
@section('title','Revenue Budget')
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
                <form action="{{route('revenuebudget.store')}}" method="post">
                <div class="card-header"><button type="submit" class="btn btn-primary"><i class="la la-save"></i>Save</button></div>
                <div class="col-12 my-3">

                        @csrf
                        <div class="col-6 offset-3">
                            <div class="form-group">
                                <label for="">Budget Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" name="year">
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
                                @foreach($coas as $item)
                                    <tr>
                                        <td>{{$item->code}}</td>
                                        <td>{{$item->name}}</td>
                                        <td><input type="text" class="form-control" name="cost_center[{{$item->id}}]" placeholder="Enter Cost Center"></td>
                                        <td><input type="text" class="form-control" name="dept[{{$item->id}}]" placeholder="Department"></td>
                                        <td><input type="text" class="form-control" name="total[{{$item->id}}]" id="total_{{$item->id}}" placeholder="Total" readonly=""></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jan[{{$item->id}}]" placeholder="Jan"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="feb[{{$item->id}}]" placeholder="Feb"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="mar[{{$item->id}}]" placeholder="Mar"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="apr[{{$item->id}}]" placeholder="Apr"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="may[{{$item->id}}]" placeholder="May"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jun[{{$item->id}}]" placeholder="Jun"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="jul[{{$item->id}}]" placeholder="Jul"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="aug[{{$item->id}}]" placeholder="Aug"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="sep[{{$item->id}}]" placeholder="Sep"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="oct[{{$item->id}}]" placeholder="Oct"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="nov[{{$item->id}}]" placeholder="Nov"></td>
                                        <td><input type="text" class="form-control estimate_{{$item->id}}" name="dec[{{$item->id}}]" placeholder="Dec"></td>
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