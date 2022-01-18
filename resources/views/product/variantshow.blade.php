@extends("layout.mainlayout")
@section('title','Product Details')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Product Variant</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/products")}}">Product</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('products.show',$product->product_id)}}">Variant</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h4>Product Specification</h4>
                </div>
               <div class="row">
                   <div class="col-md-6">
                       <div class="col-md-12 mt-3">
                           <div class="row">
                               <div class="col-md-4">Barcode</div>
                               <div class="col-md-8">
                                   <div id="barcodeTarget" class="barcodeTarget"></div>
                                   <canvas id="canvasTarget" width="100" height="50"></canvas>
                               </div>
                           </div>
                       </div>
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-4">Product Name </span><span class="col-md-8">: {{$product->product_name}}</span>
                           </div>
                       </div>
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-4">Model No </span><span class="col-md-8">: {{$product->product->model_no??'N/A'}}</span>
                           </div>
                       </div>
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-4">Main Category</span><span class="col-md-8">: {{$product->product->category->name}}</span>
                           </div>
                       </div>
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-4">Sub-Category</span><span class="col-md-8">: {{$product->product->sub_cat->name??'N/A'}}</span>
                           </div>
                       </div>
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-4">Brand</span><span class="col-md-8">: {{$product->sub_cat->name??'N/A'}}</span>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <h5 class="mt-3">Warehouse Info</h5>
                       @foreach($stock as $item)
                           <div class="col-12 my-1">
                               <div class="row">
                                   <span class="text-muted col-md-6">Stock Balance in {{$item->warehouse->name}}</span><span class="col-md-6">: {{$item->stock_balance??'N/A'}} </span>
                               </div>
                           </div>
                           @endforeach
                       <h5 class="mt-1">Selling Info</h5>
                      @foreach($selling_info as $item)
                       <div class="col-12 my-1">
                           <div class="row">
                               <span class="text-muted col-md-6">{{$item->sale_type}}({{$item->unit}})</span><span class="col-md-6">: {{$item->price??'N/A'}} MMK</span>
                           </div>
                       </div>
                          @endforeach
                   </div>
               </div>
                <div class="col-12">
                    <h5>Detail</h5>
                    <div  style="min-height: 100px">
                        <p class="mx-3 my-3" id="detail"> {!! $product->product->description !!}</p>
                    </div>
                </div>
                <div class="col-12">
                    <h5>Detail</h5>
                    <div  style="min-height: 100px">
                        <textarea class="mx-3 my-3" id="description"> {!! $product->description !!}</textarea>
                    </div>
                </div>

                <div class="col-12 my-3">
                    <h5>Images</h5>
                    <div class="row my-1">
                        @foreach(json_decode($product->image) as $image)
                            <img src="{{url(asset('/product_picture/'.$image))}}" alt="" class="border mr-2 ml-2" style="max-height:200px;max-width:100%;border: solid">
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var btype ="std25";
            var renderer ="css";
            var value="{{$product->product_code}}";


            var settings = {
                output:renderer,
                bgColor: '#FFFFFF',
                color: '#000000',
                barWidth: '1',
                barHeight: '20',
                moduleSize: '5',
                posX: '10',
                posY: '20',
                addQuietZone: '1'
            };

            if (renderer == 'canvas'){
                clearCanvas();
                $("#barcodeTarget").hide();
                $("#canvasTarget").show().barcode(value, btype, settings);
            } else {
                $("#canvasTarget").hide();
                $("#barcodeTarget").html("").show().barcode(value, btype, settings);
            }


            function clearCanvas(){
                var canvas = $('#canvasTarget').get(0);
                var ctx = canvas.getContext('2d');
                ctx.lineWidth = 1;
                ctx.lineCap = 'butt';
                ctx.fillStyle = '#FFFFFF';
                ctx.strokeStyle  = '#000000';
                ctx.clearRect (0, 0, canvas.width, canvas.height);
                ctx.strokeRect (0, 0, canvas.width, canvas.height);
            }
        });

        ClassicEditor.create($('#description')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
        ClassicEditor.create($('#detail')[0], {
            toolbar: ['heading', 'bold', 'italic', 'undo', 'redo', 'numberedList', 'bulletedList', 'insertTable']
        });
    </script>
@endsection