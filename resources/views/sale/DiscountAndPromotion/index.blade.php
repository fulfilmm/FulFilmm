@extends("layout.mainlayout")
@section('title','Product Discount And Promotion')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Promotion And Discount</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/discount_promotions")}}">Promotion And Discount</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route("discount_promotions.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add Promotion and Discount</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Variant</th>
                    <th>Type</th>
                    <th>Discount For</th>
                    <th>Rate</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($promo_discounts as $item)
                    <tr>
                        <td><strong>{{$item->variant->product_code}}</strong></td>
                        <td>{{$item->variant->product_name}}</td>
                        <td>{{$item->variant->variant}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->sale_type}}</td>
                        <td>{{$item->rate}} %</td>
                        <td>{{$item->start_date!=null?\Carbon\Carbon::parse($item->start_date)->toFormattedDateString():'N/A'}}</td>
                        <td>{{$item->end_date!=null?\Carbon\Carbon::parse($item->end_date)->toFormattedDateString():'N/A'}}</td>
                        <td>
                            <div class="row">
                                <a href="{{route('discount_promotions.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                                <form action="{{route('discount_promotions.destroy',$item->id)}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection