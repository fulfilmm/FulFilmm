@extends('layout.mainlayout')
@section("title","Quotation")
@section('content')

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Quotation</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url("home")}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Quotation</li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto float-right ml-auto my-2">
                    <a href="{{route('quotations.create')}}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Quotation</a>
                </div>

            </div>
            <!-- /Page Header -->

            <!-- Content Starts -->
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Sale Person</th>
                    <th>Payment Term</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
{{--                @dd($all_quotation)--}}
                    @foreach($all_quotation as $quotation)
                        <tr>
                            <td><a href="{{route('quotations.show',$quotation->id)}}">#{{$quotation->quotation_id}}</a></td>
                            <td>{{$quotation->customer->name}}</td>
                            <td>{{$quotation->sale_person->name}}</td>
                            <td>{{$quotation->payment_term}}</td>
                            <td>{{$quotation->grand_total}}</td>
                            <td class="text-center">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url("/quotation/edit/$quotation->id")}}" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_quotation{{$quotation->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </div>
                                <div class="modal fade" id="delete_quotation{{$quotation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content  modal-sm mr-auto ml-auto">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Quotation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                <span>
                                                    Are you sure delete "{{$quotation->quotation_id}}"?
                                              </span>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button data-dismiss="modal" class="btn btn-outline-primary">No</button>
                                                <a href="{{route("quotations.destroy",$quotation->id)}}" class="btn btn-danger  my-2">Yes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- /Content End -->

        </div>
        <!-- /Page Content -->

@endsection
