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
            </div>
        </div>
        <div class="col-12 col-md-8 offset-md-2">
            <form action="{{route('discount_promotions.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pid">Product Name</label>
                            <select name="variant_id" id="pid" class="form-control select2">
                                @foreach($products as $item)
                                    <option value="{{$item->id}}">{{$item->product_name}}({{$item->variant}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regionid">Region </label>
                            <select name="region_id" id="regionid" class="form-control select2">
                                @foreach($region as $item)
                                    <option value="{{$item->id}}" {{$item->id==old('region_id')?'selected':''}}>{{$item->name}} ({{$item->branch->name}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type{{$}}" class="form-control">
                                <option value="Discount">Discount</option>
                                <option value="Promotion">Promotion</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" class="form-control" name="start_date" value="{{old('start_date')?\Carbon\Carbon::parse(old('start_date'))->format('Y-m-d'):''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" class="form-control" name="end_date" value="{{old('end_date')?\Carbon\Carbon::parse(old('end_date'))->format('Y-m-d'):''}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rate">Sale Type</label>
                            <select name="sale_type" id="" class="form-control">
                                <option value="Whole Sale">Whole Sale</option>
                                <option value="Rental Sale">Rental Sale</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rate">Rate</label>
                            <div class="input-group">
                                <input type="number" id="rate" name="rate" class="form-control" >
                                <button type="button" class="btn btn-white">%</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function generatecode(){
            var pcode='{{random_int(100000000,999999999)}}';
            $("#p_code").val(pcode);
        }
        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
@endsection