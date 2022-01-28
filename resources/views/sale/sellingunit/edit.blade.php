@extends("layout.mainlayout")
@section('title','Add Selling Unit')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Selling Unit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("sellingunits")}}">Selling Unit</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <form action="{{route('sellingunits.update',$unit->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-8 offset-md-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pid">Product Name</label>
                            <select name="variant_id" id="pid" class="form-control select2" required>
                                @foreach($products as $pd)
                                    <option value="{{$pd->id}}" {{$pd->id==$unit->variant_id?'selected':''}}>{{$pd->product_name}}({{$pd->variant}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit">Selling Unit</label>
                            <input type="text" name="unit" id="unit" class="form-control" value="{{$unit->unit}}" placeholder="Enter Selling Unit" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Unit Convert Rate</label>
                            <input type="number" class="form-control" name="unit_convert_rate" value="{{$unit->unit_convert_rate}}" placeholder="Enter Unit Convert Rate" required>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection