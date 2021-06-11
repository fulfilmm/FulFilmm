@extends("layout.mainlayout")
@section("title","Cases Type")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">InQuery</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home.blade.php")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Inquery</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="col-12" style="overflow-x: auto">
            <table class="table " id="inquery_table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Description</th>
                    <th scope="col">Township</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Convert To Lead</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inqueries as $inquery)
                    <tr>
                        <td>#{{$inquery->id}}</td>
                        <td><a href="{{route('inqueries.show',$inquery->id)}}">{{$inquery->subject}}</a></td>
                        <td>{{$inquery->customer_name}}</td>
                        <td>{{$inquery->email}}</td>
                        <td>{{$inquery->phone}}</td>
                        <td>{{$inquery->description}}</td>
                        <td>{{$inquery->township}}</td>
                        <td>
                            @php
                                $inquery_products=json_decode(($inquery->product));
                            @endphp
                            @for($i=0;$i<count($inquery_products);$i++ )
                                @foreach($products as $product)
                                    @if($product->id==$inquery_products[$i])
                                        <a href="{{url("product/show/$product->id")}}" title="{{$product->name}}">
                                            <img src="{{url(asset("/product_picture/$product->image"))}}" class="border rounded" alt="product picture" width="40px" height="40px;"></a>
                                    @endif
                                @endforeach
                            @endfor
                        </td>
                        <td>@if($inquery->convert_lead==1)Converted @else Did Not Convert @endif</td>
                        <td>{{$inquery->created_at->toFormattedDateString()}}</td>
                        <td>
                            <div class="dropdown ">
                                <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th-list"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="" class="dropdown-item" data-toggle="modal" data-target="#inquery{{$inquery->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit mr-2"></i>Edit</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#delete{{$inquery->id}}"><i class="fa fa-trash mr-2"></i>Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @include('inquery.delete')
                    @include('inquery.edit')
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $("#inquery_table").DataTable();
        });
    </script>
@endsection
