@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Daily Summary</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                        <li class="breadcrumb-item active">
                            Daily Summary
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <form action="{{route('summary.index')}}" method="get">
            @csrf
        <div class="row">
            <div class="col-11">
               <div class="col-12">
                   <div class="row">
                       <div class="col">
                           <div class="form-group">
                               <label for="">Branch</label>
                               <select name="branch_id" id="branch_id" class="form-control">
                                   <option value="">All</option>
                                   @foreach($branches as $bh)
                                       <option value="{{$bh->id}}" {{$bh->id==$branch_id?'selected':''}}>{{$bh->name}}</option>
                                   @endforeach
                               </select>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label for="">Employee</label>
                               <select name="emp_id" id="" class="form-control">
                                  @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='Super Admin'||\Illuminate\Support\Facades\Auth::guard('employee')->user()->role->name=='CEO')
                                       <option value="">All</option>
                                       @foreach($employees as $emp)
                                           <option value="{{$emp->id}}" {{$emp->id==$emp_id?'selected':''}}>{{$emp->name}}</option>
                                       @endforeach
                                      @else
                                       @foreach($employees as $emp)
                                           @if($emp->id==\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                               <option value="{{$emp->id}}" {{$emp->id==$emp_id?'selected':''}}>{{$emp->name}}</option>
                                               @endif
                                       @endforeach
                                   @endif
                               </select>
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label for="">Start Date</label>
                               <input type="date" class="form-control" name="start" value="{{$start->format('Y-m-d')}}">
                           </div>
                       </div>
                       <div class="col">
                           <div class="form-group">
                               <label for="">End Date</label>
                               <input type="date" class="form-control" name="end" value="{{$end->format('Y-m-d')}}">
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            <div class="col-1 mt-4">
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary"><i class="la la-search"></i></button>
                </div>
            </div>
        </div>
        </form>

        <div class="col-12">
            <div class="card shadow">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="home" aria-selected="true">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#item" role="tab" aria-controls="profile" aria-selected="false">Stock</a>
                    </li>
                </ul>
                {{--@dd($stock)--}}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-12" style="overflow: auto">
                            <table class="table table-hover table-hover" id="sale_summary">
                                <thead>
                                <tr>
                                    <th style="width: 130px;">Date</th>
                                    <th style="width: 130px;">Invoice Id</th>
                                    <th>Office</th>
                                    <th>Customer</th>
                                    <th>Salesman</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Due </th>
                                    <th>Paid </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice as $inv)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($inv->invoice_date)->toFormattedDateString()}}</td>
                                            <td>{{$inv->invoice_id}}</td>
                                            <td>{{$inv->branch->name}}</td>
                                            <td>{{$inv->customer->name}}</td>
                                            <td>{{$inv->employee->name}}</td>
                                            <td>{{$inv->status}}</td>
                                            <td>{{$inv->grand_total}}</td>
                                            <td>{{$inv->due_amount}}</td>
                                            <td>{{$inv->grand_total-$inv->due_amount}}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td>{{$total_sale_amount[0]->total??0}}</td>
                                        <td>{{$debt_amount[0]->total??0}}</td>
                                        <td>{{$paid_amount}}</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Cash In Transit</td>
                                        <td>{{$cash_in_transit??0}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="item" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col-12">
                            <table class="table table-hover table-hover" id="stock_summary">
                                <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Name</th>
                                    <th>Variant</th>
                                    <th>Warehouse</th>
                                    <th>Sold Qty</th>
                                    <th>Balance</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($origin_stock as $item)
                                    <tr>
                                        <td>{{$item->variant->product_code}}</td>
                                        <td>{{$item->variant->product_name}}</td>
                                        <td>{{$item->variant->variant}}</td>
                                        <td>{{$item->warehouse->name}}</td>
                                        <td>{{$item->sold_qty??0}}
                                        </td>
                                        <td>{{$item->stock_balance}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="float-right">Total</td>
                                        <td>{{$total_sold??0}}</td>
                                        <td>{{$total_balance}}</td>

                                    </tr>
                                </tfooter>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#sale_summary').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
            $('#stock_summary').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });

    </script>
    @endsection