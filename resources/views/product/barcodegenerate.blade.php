@extends("layout.mainlayout")
@section("title","Products")
@section("content")
    <!-- Page Wrapper -->
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="col-md-6 col-sm-6 col-12 offset-md-3 offset-sm-3 offset-0">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-6 offset-md-2 col-6 offset-2" id="print_me">
                        <h5 align="center">{{ucfirst($product->product_name)}} ({{$product->variant}})</h5>
                        <div class="row border">
                            <div class="col-md-12 mt-2 text-center">

                                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($product->item_code, $type)}}" alt="barcode" />
                                <div class="text-center">{{$type}} : {{$product->product_code}}</div>
                            </div>
                            <div class="col-md-12 text-center">
                                <span>Price :{{$product_price->price??0}} MMK</span>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-primary float-right"
                                onclick="printContent('print_me');" id="print">Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <div id="print_me" style="visibility: hidden"></div>
            <script>
                function printContent(el) {
                    // document.title = ;
                    var restorepage = $('body').html();
                    $('#myTab').remove();
                    var printcontent = $('#' + el).clone();
                    $('body').empty().html(printcontent);
                    $('.footer').hide();
                    window.print();
                    $('body').html(restorepage);
                }
            </script>
@endsection