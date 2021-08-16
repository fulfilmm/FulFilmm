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
            <div class="col-md-12">
               <div class="card">
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Name</label>
                           <input type="text" class="form-control" readonly value="{{$complain->name}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Email</label>
                           <input type="text" class="form-control" readonly value="{{$complain->email}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Phone</label>
                           <input type="text" class="form-control" readonly value="{{$complain->phone}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Address</label>
                           <input type="text" class="form-control" readonly value="{{$complain->address}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Product</label>
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <img src="{{url(asset("/product_picture/".$complain->compalin_product->image))}}" class="my-2 border rounded"  alt="product picture" style="min-width: 100px;min-height: 100px; max-width: 200px;max-height: 100px;">
                           <input type="text" class="form-control" readonly value="{{$complain->compalin_product->name}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Company</label>
                           <input type="text" class="form-control" readonly value="{{$complain->complain_company->name}}">
                       </div>
                   </div>
                   <div class="col-12">
                       <div class="form-group">
                           <label for="">Description</label>
                           <div class="form-control" readonly>{!! $complain->description !!} </div>
                       </div>
                   </div>
                   <div class="col-12">
                       <label for=""> {{$complain->attach_file!=null?'Attach File':''}}</label>
                       <a href="{{url(asset('ticket_attach/'.$complain->attach_file))}}" download>
                       <div class=" col-1 rounded border mb-3">
                           <i class="{{$complain->attach_file!=null?'la la-paperclip':''}} rounded" style="font-size: 30px" ></i>
                       </div>
                       </a>
                   </div>
                   <div class="col-12">
                       <label for=""> {{$complain->image!=null?'Image':''}}</label>
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
                   <div class="col-12">
                       <div class="form-group">
                           <a href="{{route('openticket',$complain->id)}}" class="btn btn-primary">Open Ticket</a>
                       </div>
                   </div>
               </div>
            </div>
        </div>

    </div>
@endsection