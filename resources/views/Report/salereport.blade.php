@extends('layout.mainlayout')
@section('title','Sale Report')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Sale Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Sale Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{url('selling/report')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="branch">Branch</label>
                            <select name="branch_id" id="branch" class="form-control">
                                <option value="">All</option>
                               @foreach($branch as $key=>$val)
                                <option value="{{$key}}" {{$key==$search_branch?'selected':''}}>{{$val}}</option>
                                   @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Start Date</label>
                            <input type="date" class="form-control shadow-sm" name="start" value="{{$start->format('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">End Date</label>
                            <div class="input-group">
                                <input type="date" class="form-control shadow-sm" name="end" value="{{$end->format('Y-m-d')}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-white shadow-sm"><i class="la la-search"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Whole Sale</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$total_sale_amount[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style=""
                                             aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Retail Sale</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$total_reatail_sale[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </a>
                        </div>


                        <div class="card shadow">
                            <a href="{{url('revenue')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between ">
                                        <div>
                                            <span class="d-block">Total Sale</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">{{$total_sale[0]->total??0}}</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        <span class="text-success"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card shadow">
                            <a href="{{route('invoices.index')}}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="d-block">Debt</span>
                                        </div>

                                    </div>
                                    <h3 class="mb-3">{{$debt_amount[0]->total??0}}</h3>

                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                             aria-valuemax="100"></div>

                                    </div>
                                    <div>
                                        <span class="text-success"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table id="sale_table" class="table table-hover table-nowrap "  style="width: 100%">
                <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Sold Qty</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr><tbody>

                @foreach($data as $item)
                    <tr>
                        <td>{{$item->variant->product_code}}</td>
                        <td>{{$item->variant->product_name}}</td>
                        <td>{{$item->variant->variant}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->unit->unit}}</td>
                        <td>{{$item->unit_price}}</td>
                        <td>{{$item->total}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>{{$total_sale[0]->total}}</td>
                    <td></td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
@endsection
