@extends('layout.mainlayout')
@section('title','Stock')
<style>
    svg{
        height: 18px;
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="page-header my-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('show.transfer')}}" class="btn add-btn btn-sm"><i class="fa fa-plus"></i>Stock Transer</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive my-3 col-12">
                <table class="table " id="stock">
                    <thead>
                    <tr>
                        <th>Sku</th>
                        <th>Product </th>
                        <th>Variants</th>
                        <th>Warehouse</th>
                        <td>Stock Balance</td>
                        <td>Available Stock</td>
                        <td>Alert Qty</td>
                        <td>Last Updated</td>
                    </tr>

                    </thead>
                    <tbody>
                    {{--@dd($stocks)--}}
                    @foreach($stocks as $stock)
                       @if($stock->warehouse_id!=null)
                           <tr>
                               <td><strong>{{$stock->sku}}</strong></td>
                               <td>{{$stock->product->name}}</td>
                               <td>@foreach($sku_value as $variant)@if($variant->sku_id==$stock->id) {{$variant->variant->name}}:{{$variant->variant_value->value}} @endif @endforeach</td>
                               <td><a href="{{route('warehouses.show',$stock->warehouse->id)}}">{{$stock->warehouse->name}}</a></td>
                               <td>{{$stock->stock_balance}}</td>
                               <td>{{$stock->available}}</td>
                               <td>{{$stock->alert_qty}}</td>
                               <td>{{\Carbon\Carbon::parse($stock->updated_at)->toFormattedDateString()}}</td>
                           </tr>
                           @endif
                    @endforeach
                    </tbody>

                </table>
                {!! $stocks->links() !!}
            </div>
        </div>
    </div>
    {{--<script src="{{url(asset('js/jquery_print.js'))}}"></script>--}}
    {{--<script src="{{url(asset('js/datatable_button.js'))}}"></script>--}}
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--$('#stock').DataTable();--}}
            {{--$('.dataTables_filter input').remove('form-control');--}}
            {{--$('.dataTables_filter input').addClass('rounded');--}}
        {{--});--}}
    {{--</script>--}}

@endsection