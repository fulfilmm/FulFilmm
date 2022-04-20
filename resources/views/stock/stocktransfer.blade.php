@extends('layout.mainlayout')
@section('title','Stock Transfer')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Stock Transfer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                        <li class="breadcrumb-item active">Transfer</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-12">
            <div class="card shadow">
                <div class="col-12 my-3">
                    <form action="{{route('stocks.transfer')}}" method="post">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="warehouse">My Warehouse <span class="text-danger"> * </span></label>
                                    <select name="current_warehouse_id" id="current_warehouse" class="form-control">
                                        @foreach($warehouse as $item)
                                            @if($item->branch_id==\Illuminate\Support\Facades\Auth::guard('employee')->user()->office_branch_id)
                                                <option value={{$item->id}} {{old('current_warehouse_id')==$item->id?'selected':''}}>{{$item->name}}</option>
                                                @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="warehouse">Transfer Warehouse <span class="text-danger"> * </span></label>
                                    <select name="transfer_warehouse_id" id="warehouse" class="form-control" >
                                        @foreach($warehouse as $item)
                                                <option value={{$item->id}} {{old('current_warehouse_id')==$item->key?'selected':''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="variantion_id">Product <span class="text-danger"> * </span></label>
                                    <select name="variantion_id" id="variantion_id" class="form-control">
                                        @foreach($products as $item)
                                        <option value="{{$item->id}}">{{$item->product_name}} ({{$item->variant}})</option>
                                            @endforeach
                                    </select>
                                    @error('variantion_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="receiver">Receiver</label>
                                    <select name="approver_id" id="approver" class="form-control">
                                        @foreach($employees as $emp)
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="qty">Quantity <span class="text-danger"> * </span></label>
                                    <input type="number" name="qty" class="form-control" value={{old('qty')}}>
                                </div>
                                @error('qty')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary text-center">Stock Transfer</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('select').select2();

        });
    </script>
@endsection