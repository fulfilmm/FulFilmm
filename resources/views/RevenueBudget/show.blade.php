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
                    <div class="card-header"><a href="{{route('revenuebudget.edit',$revenue_budget->id)}}"  class="btn btn-success"><i class="la la-edit"></i>Edit</a></div>
                    <div class="col-12 my-3">
                        <div class="col-12 ">
                            <div class="form-group">
                                <label for="">Budget Name :{{$revenue_budget->name}}</label><br>
                                <label for="year">Year :{{$revenue_budget->year}}</label>
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
                                        <td>{{$item->cost_center}}</td>
                                        <td>{{$item->department}}</td>
                                        <td>{{$item->total}}</td>
                                        <td>{{$item->jan}}</td>
                                        <td>{{$item->feb}}</td>
                                        <td>{{$item->mar}}</td>
                                        <td>{{$item->apr}}</td>
                                        <td>{{$item->may}}</td>
                                        <td>{{$item->jun}}</td>
                                        <td>{{$item->jul}}</td>
                                        <td>{{$item->aug}}</td>
                                        <td>{{$item->sep}}</td>
                                        <td>{{$item->oct}}</td>
                                        <td>{{$item->nov}}</td>
                                        <td>{{$item->dec}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection