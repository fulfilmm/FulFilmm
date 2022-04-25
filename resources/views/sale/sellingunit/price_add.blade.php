@extends("layout.mainlayout")
@section('title','Add Selling Unit')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Selling Unit</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("sellingunits")}}">Selling Unit</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a  class="btn btn-white float-right mr-3 mt-3 shadow rounded-pill" data-toggle="modal" data-target="#add_price" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New Price</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-5" style="overflow: auto">
                    <form action="{{route('store.price')}}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pid">Product Name</label>
                                        <select  id="main_pid" onchange="giveSelection(this.value)" class="form-control select2 shadow"  style="width: 100%" required>
                                            @foreach($main_product as $pd)
                                                <option value="{{$pd->id}}">{{$pd->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pid">Variant</label>
                                        <select name="product_id[]" id="pid"  class="form-control select2 shadow" multiple style="width: 100%" required>
                                            @foreach($products as $pd)
                                                <option value="{{$pd->id}}" data-option="{{$pd->product_id}}">{{$pd->variant}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="unit_id">Unit</label>
                                        <div class="input-group">
                                            <select name="unit_id" id="unit_id" class="form-control" required  style="width: 100%">
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}" data-option="{{$unit->product_id}}">{{$unit->unit}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sale_type">Sale Type</label>
                                        <select name="sale_type" id="sale_type" class="form-control" style="width: 100%">
                                            <option value="Whole Sale">Whole Sale</option>
                                            <option value="Retail Sale">Retail Sale</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="region">Region</label>
                                        <select name="region_id[]" id="region" class="form-control" multiple>
                                            @foreach($region as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    @error('branch_id')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Unit Price</label>
                                        <input type="number" class="form-control shadow-sm" name="single_price" placeholder="Enter Unit Price">
                                    </div>
                                </div>
                               <div class="col-12">
                                   <div class="form-group">
                                       <input type="radio" id="price_multi" name="type" onclick="price_type(1)" value="multi">
                                       <label for="price_multi">Multiple Price</label>
                                       <input type="radio" id="price_single" name="type" onclick="price_type(0)" checked value="single">
                                       <label for="price_single">Single Price</label>
                                   </div>
                               </div>
                                <div class="collapse" id="multi_price">
                                    <div class="col-12">
                                        <div class="row">
                                            <input type="hidden" name="row_no[]" value="rowno">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="rule">Rule Description</label>
                                                    <input type="text" class="form-control form-control-sm rounded" name="rule[]" id="rule">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="min">Min Quantity</label>
                                                    <input type="number" class="form-control form-control-sm rounded" name="min_qty[]" id="min">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="Max">Max Quantity</label>
                                                    <input type="number" class="form-control form-control-sm rounded" name="max_qty[]" id="max">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" class="form-control form-control-sm rounded" id="start_date" name="start_date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" class="form-control form-control-sm rounded" id="end_date" name="end_date[]">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="price">Price</label>
                                                    <input type="number" class="form-control form-control-sm rounded" name="price[]" id="price[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="newRow">

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button id="addRow" type="button" class="btn btn-white btn-sm float-right">Add More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <script>
            var product = document.querySelector('#main_pid');
            var unit = document.querySelector('#unit_id');
            var pid = document.querySelector('#pid');
            var options2 = unit.querySelectorAll('option');
            var options3 = pid.querySelectorAll('option');
            // console.log(options3);
            function giveSelection(selValue) {
                unit.innerHTML = '';
                pid.innerHTML = '';
                for(var i = 0; i < options2.length; i++) {
                    if(options2[i].dataset.option === selValue) {
                        unit.appendChild(options2[i]);
                    }
                }
                for(var i = 0; i < options3.length; i++) {
                    if(options3[i].dataset.option === selValue) {
                        pid.appendChild(options3[i]);
                    }
                }
            }
            giveSelection(product.value);
            $(document).ready(function () {
                $('select').select2();
            });
            function price_type(val){
                if(val==1){
                    $('#multi_price').show();
                    $('#single_price').hide();
                }else{
                    $('#single_price').show();
                    $('#multi_price').hide();
                }
            }
            $("#addRow").click(function () {
                var html = '';
                html +='<div id="inputFormRow" class="row">';
                html +=' <input type="hidden" name="row_no[]" value="rowno">';
                html += '<div class="col-md-2">';
                html +='<div class="form-group">';
                html +='<label for="rule">Rule Description</label>';
                html +='<input type="text" class="form-control form-control-sm rounded" name="rule[]" id="rule">';
                html +='</div>';
                html +='</div>';
                html += '<div class="col-md-2">';
                html +='<div class="form-group"><label for="min">Min Quantity</label>' +
                    '<input type="number" class="form-control form-control-sm rounded" name="min_qty[]" id="min">';
                html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">' +
                    '<div class="form-group">' +
                    '<label for="Max">Max Quantity</label>' +
                    '<input type="number" class="form-control form-control-sm rounded" name="max_qty[]" id="max">' +
                    '</div>';
                html +='</div>';
                html += '<div class="col-md-2">';
                html +='<div class="form-group">' +
                    '<label for="start_date">Start Date</label>' +
                    '<input type="date" class="form-control form-control-sm rounded" id="start_date" name="start_date[]">' +
                    '</div>';
                html +='</div>';
                html += '<div class="col-md-2">';
                html +='<div class="form-group">' +
                    '<label for="end_date">End Date</label>' +
                    '<input type="date" class="form-control form-control-sm rounded" id="end_date" name="end_date[]">' +
                    '</div>';
                html +='</div>';
                html += '<div  class="col-md-2">';
                html +='<div class="form-group"> <label>Price</label>';
                html += '<div class="input-group">';
                html += '<input type="text" name="price[]" class="form-control  form-control-sm rounded" autocomplete="off">';
                html += '<div class="input-group-append">';
                html += '<button id="removeRow" type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#newRow').append(html);
            });

            // remove row
            $(document).on('click', '#removeRow', function () {
                $(this).closest('#inputFormRow').remove();
            });

        </script>
@endsection