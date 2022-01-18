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
                    <a href="{{route("sellingunits.create")}}" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New Unit</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Barcode</th>
                   <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Sale Type</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Created Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($sellingunits as $item)
                        <tr>
                            <td>
                                <div id="barcodeTarget" class="barcodeTarget"></div>
                                <canvas id="canvasTarget" width="100" height="50"></canvas>
                                <script>
                                        $(document).ready(function () {
                                            var pcode='{{$item->barcode}}';
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
                                        });
                                </script>
                            </td>
                            <td><strong>{{$item->variant->product_code}}</strong></td>
                            <td>{{$item->variant->product_name}}</td>
                            <td>{{$item->sale_type}}</td>
                            <td>{{$item->unit}}</td>
                            <td>{{$item->price}}</td>
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
@endsection
