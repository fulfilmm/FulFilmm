@extends("layout.mainlayout")
@section("title","Quotation Detail")
@section("content")
    <style>
        @media print {
            title {
                font-size:24px;
            }
        }
    </style>
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{$quotation->quotation_id}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Quotation</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Content Starts -->

        <form action="{{url("quotation/create")}}" method="POST" >
            {{csrf_field()}}
            <a href="{{route('quotations.edit',$quotation->id)}}" class="btn btn-outline-primary" >Edit</a>
            <a href="{{route('quotations.create')}}" class="btn btn-outline-success" id="discard">Create</a>
            <button id="print" class="btn btn-outline-danger" onclick="printContent('print_me');" ><i class="fa fa-print"></i> Print</button>
            <hr>
            <a href="{{url("/quotations/sendemail/$quotation->quotation_id")}}" class="btn btn-outline-primary" id="send_email">SendByEmail</a>
            <button class="btn btn-outline-primary" id="confirm">Confirm</button>
            <hr>
            <div class="card" id="print_me">
                <div class="col-12 mt-3">
                    <input type="hidden" id="quotation_id" name="quotation_id" value="{{$quotation->id}}">
                    <strong>{{$quotation->quotation_id}}</strong>
                    <div class="row mt-3">
                        <div class="col-md-1 col-4">  <label for="">Customer</label></div>
                        <div class="col-md-5 col-8">
                            <div class="form-group">
                                <span> : {{$quotation->customer->name}}</span>
                            </div>
                        </div>
                        <div class="col-md-1 col-4 ">
                            <label for="">Expiration</label>
                        </div>
                        <div class="col-md-4 col-8">
                            <div class="form-group">
                                <span> : {{$quotation->exp_date}}</span>
                            </div>
                        </div>
                        <div class="offset-md-6 offset-0 col-md-1 col-5">
                            <label for="">Payment Terms</label>
                        </div>
                        <div class="col-md-4 col-6 col-7" >
                            <span> : {{$quotation->payment_term}}</span>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Order Line</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Optional Products</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Terms and Conditions</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x: auto">
                            <table class="table" >
                                <thead>
                                <th scope="col">Product Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Taxes(%)</th>
                                <th>Total(Include Tax)</th>
                                </thead>
                                <tbody id="tbody">
                                @foreach($orderline as $order)
                                    <tr>
                                        <td>
                                            {{$order->product->name}}
                                        </td>
                                        <td>{{$order->description}}</td>
                                        <td>{{$order->quantity}}</td>
                                        <td>{{$order->price}}</td>
                                        <td>{{$order->tax}}%</td>
                                        <td>{{$order->total_amount}}
                                            <input type="hidden" class="total" value="{{$order->total_amount}}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>Grand Total</th>

                                    <td>{{$grand_total}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <h3>Terms and Conditions</h3>
                            <div>
                                <p class="ml-5 mt-3">{{$quotation->terms_conditions}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    <div id="print_me"  style="visibility: hidden">

    </div>
    <script>
        function printContent(el){
            // document.title = ;
            var restorepage = $('body').html();
            $('#myTab').remove();
            var printcontent = $('#' + el).clone();
            printcontent.append('<div class="ml-4 my5"><h3 >Terms and Condition</h3><p>{{$quotation->terms_conditions}}</p></div>');
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
    <!-- /Page Wrapper -->
@endsection
