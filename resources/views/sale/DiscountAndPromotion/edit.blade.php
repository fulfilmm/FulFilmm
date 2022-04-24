@extends("layout.mainlayout")
@section('title','Product Discount And Promotion Edit')
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
                        <li class="breadcrumb-item active">Edit</li>
                        <li class="breadcrumb-item active">{{$pro_discount->id}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 offset-md-2">
            <form action="{{route('discount_promotions.update',$pro_discount->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pid">Product Name</label>
                            <select name="variant_id" id="pid" class="form-control select2">
                                @foreach($products as $item)
                                    <option value="{{$item->id}}" {{$pro_discount->variant_id==$item->id?'selected':''}}>{{$item->product_name}}({{$item->variant}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Discount" {{$pro_discount->type=='Discount'?'selected':''}}>Discount</option>
                                <option value="Promotion" {{$pro_discount->type=='Promotion'?'selected':''}}>Promotion</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" class="form-control" name="start_date" value="{{$pro_discount->start_date!=null?\Carbon\Carbon::parse($pro_discount->start_date)->format('Y-m-d'):''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" class="form-control" name="end_date" value="{{$pro_discount!=null?\Carbon\Carbon::parse($pro_discount->end_date)->format('Y-m-d'):''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="region">Region</label>
                            <select name="region_id" id="region" class="form-control select2">
                                @foreach($region as $item)
                                    <option value="{{$item->id}}" {{$item->id==$pro_discount->region_id?'selected':''}}>{{$item->name}} ({{$item->branch->name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <div class="input-group">
                                <input type="number" id="rate" name="rate" value="{{$pro_discount->rate}}" class="form-control" >
                                <button type="button" class="btn btn-white">%</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{!! $pro_discount->description !!}</textarea>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
        $(document).ready(function () {
           $('select').select2();
        });
    </script>
@endsection