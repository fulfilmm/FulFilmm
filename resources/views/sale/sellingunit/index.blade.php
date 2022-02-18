@extends("layout.mainlayout")
@section('title','Selling Unit')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Selling Unit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("sellingunits")}}">Selling Unit</a></li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route("sellingunits.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill shadow" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New Unit</a>
                </div>
            </div>
        </div>
        <div class="col-12 card shadow">
           <div class="my-5">
               <table class="table table-striped custom-table datatable">
                   <thead>
                   <tr>
                       {{--<th>Product Code</th>--}}
                       <th>Product Name</th>
                       <th>Unit</th>
                       <th>Unit Convert Rate</th>
                       <th>Created Date</th>
                       <th></th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($sellingunits as $item)
                       <tr>
                           {{--<td><strong>{{$item->variant->product_code}}</strong></td>--}}
                           <td>{{$item->variant->name}}</td>
                           <td>{{$item->unit}}</td>
                           <td>{{$item->unit_convert_rate}}</td>
                           <td>{{$item->created_at->toFormattedDateString()}}</td>
                           <td>
                               <div class="row justify-content-center">
                                   <a href="{{route('sellingunits.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                                   <form action="{{route('sellingunits.destroy',$item->id)}}" method="POST">
                                       @csrf
                                       @method('Delete')
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
    </div>
@endsection
