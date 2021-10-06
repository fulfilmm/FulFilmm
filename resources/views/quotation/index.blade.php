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
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
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
                    <th>Confirm</th>
                    <th>Deal ID</th>
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
                            <td>{{$quotation->is_confirm==1?'Yes':'No'}}</td>
                            <td>@if(isset($quotation->deal_id))<a href="{{route('deals.show',$quotation->deal->id)}}">{{$quotation->deal->deal_id}}</a>@else N/A @endif</td>
                            <td>{{$quotation->grand_total}}</td>
                            <td class="text-center">
                                <div class="row">
                                    <a type="button" class="btn btn-primary btn-sm mr-2" href="{{route("quotations.edit",$quotation->id)}}"><i class="fa fa-pencil"></i></a>
                                    <a href="{{url('quotations/delete/'.$quotation->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
