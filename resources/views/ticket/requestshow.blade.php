@extends('layout.mainlayout')
@section('title','Complains Request')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Request To Open Ticket</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Request Details</li>
                    </ul>
                </div>
            </div>
        </div>
       <div class="row">
           <div class="col-md-8">
               <div class="row">
                   <div class="col-md-12">
                           <div class="row">
                               <div class="form-group col-md-6">
                                   <input type="text" class="form-control" readonly value="Customer Name : {{$complain->name}}">
                               </div>
                               <div class="form-group col-md-6">
                                   <input type="text" class="form-control" readonly value="Email :{{$complain->email}}">
                               </div>
                           </div>
                          <div class="row">
                              <div class="form-group col-md-6">
                                  <input type="text" class="form-control" readonly value="Phone : {{$complain->phone}}">
                              </div>
                              <div class="form-group col-md-6">
                                  <input type="text" class="form-control" readonly value="Address :{{$complain->address}}">
                              </div>
                          </div>
                           <div class="form-group">
                               <input type="text" class="form-control" readonly value="Company : {{$complain->complain_company->name??''}}">
                           </div>
                           <div class="form-group">
                               <label for="">Description</label>
                               <div class="form-control" readonly>{!! $complain->description !!} </div>
                           </div>
                       <div class="card">
                           <div class="form-group my-3 mx-3">
                               <label for="">Product</label>
                           </div>
                       @if($complain->product_id!=null)
                               <div class="col-12">
                                   <div class="form-group">
                                       <img src="{{url(asset("/product_picture/".$complain->compalin_product->image))}}" class="my-2 border rounded"  alt="product picture" style="min-width: 100px;min-height: 100px; max-width: 200px;max-height: 100px;">
                                       <input type="text" class="form-control" readonly value="{{$complain->compalin_product->name}}">
                                   </div>
                               </div>
                           @else
                               <div class="col-12">
                                   <div class="form-group">
                                       None
                                   </div>
                               </div>
                           @endif
                       </div>
                       <div class="card">
                              <div class="card-header">
                                  <label for="">Attach File</label>
                              </div>
                              <div class="col-12 my-3">
                                  <a href="{{url(asset('ticket_attach/'.$complain->attach_file))}}" download>
                                      <div class=" col-1 rounded border mb-3">
                                          <i class="{{$complain->attach_file!=null?'la la-paperclip':''}} rounded" style="font-size: 30px" ></i>
                                      </div>
                                  </a>
                              </div>
                          </div>
                       <div class="card">
                           <div class="card-header">
                               <label for="">Image</label>
                           </div>
                           <div class="col-12">

                               <div class="row">
                                   @if($photos!=null)
                                       @for($i=0;$i<count($photos);$i++)
                                           <div class="col-md-2 col-sm-6 mb-3">
                                               {{--<div class="uploaded-box" >--}}
                                               {{--<div class="uploaded-img">--}}
                                               <img src="{{url(asset("/ticket_picture/$photos[$i]"))}}" class="img-fluid" alt="" style="min-height: 40px;max-height: 100px;">
                                               {{--</div>--}}
                                               {{--</div>--}}
                                               <div class="uploaded-img-name">
                                                   <a href="{{url(asset('/ticket_picture/'.$photos[$i]))}}" download>{{$complain->image!=null?'Download':''}}</a>
                                               </div>

                                           </div>
                                       @endfor
                                   @endif
                               </div>

                           </div>
                       </div>

                       </div>
                   </div>
               </div>
           <div class="col-md-4 card">
               <div style="height: 85%">

               </div>
               <hr>
                <div class="input-group">
                    <input type="text" class="form-control" name="note" placeholder="Add Remark">
                    <button class="btn btn-white btn-sm">Add</button>
                </div>
           </div>
       </div>
        <div class="col-12">
            <div class="form-group">
                @if($complain->is_open==1)
                    <a href="" class="btn btn-primary">Have Been Open Ticket</a>
                @else
                    <a href="{{route('openticket',$complain->id)}}" class="btn btn-primary">Open Ticket</a>
                @endif
            </div>
        </div>

    </div>
@endsection