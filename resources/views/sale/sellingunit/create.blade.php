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
        <form action="{{route('sellingunits.store')}}" method="POST">
            @csrf
           <div class="col-md-8 offset-md-2">
               <div class="row">
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="pid">Product Name</label>
                           <select name="variant_id" id="pid" class="form-control select2" required>
                               @foreach($products as $pd)
                                   <option value="{{$pd->id}}">{{$pd->product_name}}({{$pd->variant}})</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="unit">Selling Unit</label>
                           <input type="text" name="unit" id="unit" class="form-control" placeholder="Enter Selling Unit" required>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="saletype">Selling Type</label>
                           <select name="sale_type" id="saletype" class="form-control select2" required>
                               <option value="Whole Sale">Whole Sale</option>
                               <option value="Rental Sale">Rental Sale</option>
                           </select>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="price">Selling Price</label>
                           <input type="number" class="form-control" name="price" placeholder="Enter Selling Price" required>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="form-group">
                           <label for="">Barcode Code</label>
                           <div class="input-group">
                               <input type="text" id="p_code" name="barcode" class="form-control" value="{{old('product_code')}}" readonly required>
                               <button type="button" class="btn btn-white btn-sm" onclick="generatecode()" id="generate">Generate Bar Code</button>
                           </div>
                           @error('product_code')
                           <span class="text-danger">{{$message}}</span>
                           @enderror
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="col-md-8">
                          <div class="form-group">
                              <label for="">Bar Code</label>
                              <div id="barcodeTarget" class="barcodeTarget"></div>
                              <canvas id="canvasTarget" width="100" height="50"></canvas>
                          </div>
                       </div>
                   </div>
                   <div class="col-12 text-center">
                       <button type="submit" class="btn btn-primary">Submit</button>
                   </div>
               </div>
           </div>
        </form>
    </div>
    <script>
        function generatecode(){
            var pcode='{{random_int(100000000,999999999)}}';
            $("#p_code").val(pcode);
            var btype ="std25";
            var renderer ="css";
            var value=pcode;


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
        }
        </script>
    @endsection