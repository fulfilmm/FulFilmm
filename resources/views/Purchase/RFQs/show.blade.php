@extends('layout.mainlayout')
@section('title','RFQs')
@section('content')
    <style>
        hr {
            border:none;
            border-top:1px dashed #000000;
            color:#fff;
            background-color:#fff;
            height:1px;
            width:100%;
        }
    </style>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>--}}
    <div class="content container-fluid">
        <!-- Page Header -->
        {{--<div class="page-header">--}}
            {{--<div class="row">--}}
                {{--<div class="col-sm-12">--}}
                    {{--<h3 class="page-title">RFQ View</h3>--}}
                    {{--<ul class="breadcrumb">--}}
                        {{--<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>--}}
                        {{--<li class="breadcrumb-item active">RFQ</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
{{--        {{$rfq->status}}--}}
       <div class="row">
           <div class="col-10">
               <div class="card shadow">
                   <div id="print_me">
                      <div class="col-12">
                          <div class="row my-5">
                              <div class="col-md-4">
                                  <img class="is-squared"
                                       src="{{$company!=null ? url(asset('/img/profiles/'.$company->logo)): url(asset('/img/profiles/avatar-01.jpg'))}}" style="max-width: 100px;max-height: 100px;">
                              </div>
                              <div class="col-4">
                                  <h3 class="text-center justify-content-center">{{$company->name??''}}</h3>
                                  <h6 class="text-center justify-content-center">{{$company->email??''}}</h6>
                                  <h6 class="text-center justify-content-center">{{$company->phone??''}}</h6>
                                  <h6 class="text-center justify-content-center">{{$company->address??''}}</h6>
                              </div>
                              <div class="col-4">
                                  <span class="float-right">Request For Quotation</span><br>
                                  <h4 class="float-right">{{$rfq->purchase_id}}</h4><br>
                              </div>
                              <div class="col">
                                  <h5 class="float-right">Status: {{$rfq->status}}</h5>
                              </div>
                              <hr>
                              <div class="col-md-6">
                                  <div class="row mt-3">
                                      <div class="col-md-3">
                                          <span class="text-muted">Vendor</span>
                                      </div>
                                      <div class="col-md-6">
                                          {{$rfq->vendor->name??'N/A'}}
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col-md-3">
                                          <span class="text-muted">Reference</span>
                                      </div>
                                      <div class="col-md-6">
                                          {{$rfq->vendor_reference}}
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  @if($rfq->status=='Confirm Order')
                                      <div class="row mt-3">
                                          <div class="col-md-12"></div>
                                          <div class="col-md-4 offset-md-2">
                                              <span class="text-muted">Confirm Date</span>
                                          </div>
                                          <div class="col-md-6">
                                              <span class="float-right">{{\Carbon\Carbon::parse($rfq->confirm_date)->toFormattedDateString()}}</span>
                                          </div>
                                      </div>
                                  @else
                                      <div class="row mt-3">
                                          <div class="col-md-12"></div>
                                          <div class="col-md-3 offset-md-6">
                                              <span class="text-muted float-right">Deadline</span>
                                          </div>
                                          <div class="col-md-3">
                                              <span class="float-right">{{\Carbon\Carbon::parse($rfq->deadline)->toFormattedDateString()}}</span>
                                          </div>
                                      </div>
                                  @endif
                                  <div class="row mt-3">
                                      <div class="col-md-12"></div>
                                      <div class="col-md-3 offset-md-6">
                                          <span class="text-muted float-right">Receipt Date</span>
                                      </div>
                                      <div class="col-md-3">
                                          <span class="float-right">{{\Carbon\Carbon::parse($rfq->receipt_date)->toFormattedDateString()}}</span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-12 mt-3">
                                <strong>Items</strong>
                                  <table class="table table-bordered">
                                      <thead>
                                      <tr>
                                          <th>Product</th>
                                          <th>Description</th>
                                          <th>Quantity</th>
                                          <th>Price</th>
                                          <th>SubTotal</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($rfq_items as $item)
                                          <tr>
                                              <td>{{$item->product->name??''}}</td>
                                              <td>{{$item->description}}</td>
                                              <td>{{$item->qty}}</td>
                                              <td>{{$item->price}}</td>
                                              <td>{{$item->total}}</td>
                                          </tr>
                                      @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="col-12">
                                  <strong>Description</strong>
                                  <p>{{$rfq->description}}</p>
                              </div>
                          </div>
                      </div>
                   </div>
               </div>
               <div class="card shadow">
                   <div class="card-header">
                       Attachment File
                   </div>
                   <div class="card-body">
                       <div class="row">
                           @foreach($attach as $key=>$val)
                               <div class="col-md-4">
                                   <ul class="files-list">
                                       @if($rfq->attach!=null)
                                           <li>
                                               <div class="files-cont">
                                                   <div class="file-type">
                                                                    <span class="files-icon"><i
                                                                                class="fa fa-file-pdf-o"></i></span>
                                                   </div>
                                                   <div class="files-info">
                                                                    <span class="file-name text-ellipsis"><a
                                                                                href="">{{$val}}</a></span>
                                                       <span class="file-date">{{$rfq->created_at}}</span>
                                                       <div class="file-size"></div>
                                                   </div>
                                                   <a class="dropdown-item"
                                                      href="{{url(asset("/attach_file/$val"))}}"><i class="fa fa-download mr-1"></i>Download</a>
                                               </div>
                                           </li>
                                       @endif
                                   </ul>
                               </div>
                           @endforeach
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-md-2">
               <div class="card shadow">
                 <div class="col-12">

                     @if($rfq->status=='Confirm Order')
                     <a href="{{route('rfq.preparemail',$rfq->id)}}"  class="btn btn-primary btn-sm col-12 my-2">{{$rfq->status=='RFQ Sent'?'Re-Sent':'SEND EMAIL'}}</a>
                    @else
                         <a href="{{route('rfqs.edit',$rfq->id)}}" class="btn btn-primary btn-sm col-12 my-2"><i class="fa fa-edit"></i> Edit</a>
                         @if($rfq->status=='RFQ Sent'||$rfq->status='Daft')
                             <a href="{{route('rfq.statuschange',[$rfq->id,'Confirm Order'])}}" class="btn btn-primary btn-sm col-12 my-2">CONFIRM </a>
                         @endif
                     @endif
                     <a href="{{route('rfq.statuschange',[$rfq->id,'Cancel'])}}" class="btn btn-primary btn-sm col-12 my-2">CANCEL</a>

                     <button class="btn btn-danger btn-sm col-12 my-2" type="button" id="create_pdf"><i class="fa fa-file-pdf-o mr-2"></i>PDF</button>
                 </div>
               </div>
               <div class="card shadow-sm">
                   <div class="card-header">
                       Followers
                   </div>
                   <div class="col-12">
                       <div class="row my-2 ml-3">
                           @foreach($followers as $follower)
                               <a href="#" data-toggle="tooltip" title="{{$follower->emp->name}}"
                                  class="avatar">
                                   <img src="{{$follower->emp->profile_img!=null? url(asset('img/profiles/'.$follower->emp->profile_img)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="">
                               </a>
                           @endforeach
                       </div>
                   </div>
               </div>
           </div>
       </div>

    </div>
    <div id="print_me"  style="visibility: hidden">
        <script src="{{url(asset('js/html2pdf.js'))}}"></script>
    <script>
        $('#create_pdf').on('click', function () {
            generatePDF();
        });
        function generatePDF() {
            // Choose the element that our invoice is rendered in.
            var element = document.getElementById('print_me');
            // Choose the element and save the PDF for our user.
            html2pdf().from(element).save('{{$rfq->purchase_id}}');
        }
    </script>
@endsection