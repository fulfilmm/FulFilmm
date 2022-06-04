@extends('layout.mainlayout')
@section('title','Add Sales Target')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Monthly Target</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sales Target</li>
                        <li class="breadcrumb-item float-right">Detail</li>
                        <li class="breadcrumb-item float-right">{{$sale_target->month}}</li>
                        <li class="breadcrumb-item float-right">{{$sale_target->employee->name}}</li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <span>Employee : </span>
                            <span>{{$sale_target->employee->name}}</span>
                        </div>
                        <div class="col">
                            <span>Target Amount : </span>
                            <span>{{$sale_target->target_sale}}</span>
                        </div>
                        <div class="col">
                            <span>Total Target Quantity : </span>
                            <span>{{$sale_target->qty}}</span>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-12">
                           <table class="table table-hover table-nowrap border">
                               <tr>
                                   <th>Product Name</th>
                                   <th>Variant</th>
                                   <th>Target Qty</th>
                                   <th>Sold Qty</th>
                               </tr>
                             @foreach($items as $item)
                                 <tr>
                                     <td>{{$item->product->product_name}}</td>
                                     <td>{{$item->product->variant}}</td>
                                     <td>{{$item->target_qty}}</td>
                                     <td>{{$item->sold_qty??0}}</td>
                                 </tr>
                                 @endforeach
                           </table>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection