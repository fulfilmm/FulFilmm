@extends('layout.mainlayout')
@section('title','Add Sales Target')
@section('content')
    <div class="container-fluid">
        <div class="page-header mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Assign Monthly Target</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item float-right">Sales Target</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12">
                    <form method="POST" action="{{route('saletargets.store')}}" accept-charset="UTF-8" id="transaction" role="form" novalidate="novalidate"  class="form-loading-button needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Month</label>
                                        <select name="month" id="month" class="form-control" style="width: 100%">
                                            @foreach($month as $key=>$val)
                                                <option value="{{$val}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                        @error('month')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <select name="year" id="year" class="form-control" style="width: 100%">
                                            @foreach($year as $item)
                                                <option value="{{$item}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="recurring">Employee</label>
                                    <div class="input-group">
                                        <select name="emp_id[]" id="emp_id" class="form-control" style="width: 90%" multiple>
                                            @foreach($employee as $key=>$val)
                                                <option value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                        @error('emp_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="target_sale">Target Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="target_sale" name="target_sale">
                                        </div>
                                        @error('target_sale')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="target_sale">Target Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="target_sale" name="target_sale">
                                        </div>
                                        @error('target_sale')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="item_table">
                                        <button type="button" class='delete btn btn-danger btn-sm'>Remove</button>
                                        <button type="button" class='addmore btn btn-white btn-sm'>Add More</button><br>
                                        <span class="text-danger" style="font-size: 12px;">!If you want to remove row,checked row checkbox and click remove button</span><br>
                                        <table class="table-hover table table-bordered" id="item_table">
                                            <tr>
                                                <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                            </tr>
                                            <tr>
                                                <td><input type='checkbox' class='case'/></td>
                                                <td><input type='text' class="form-control form-control-sm" id='product' name='product[]'/></td>
                                                <td><input type='text' class="form-control form-control-sm" id='qty' name='qty[]'/></td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row save-buttons">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-icon btn-success"><!----> <span
                                                class="btn-inner--text">Save</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        /* select tab on select change */



        $(".delete").on('click', function() {
            $('.case:checkbox:checked').parents("tr").remove();
            $('.check_all').prop("checked", false);
            check();

        });
        var i=2;
        $(".addmore").on('click',function(){
            count=$('table tr').length;
            var data="<tr><td><input type='checkbox' class='case'/></td>";
            data +="<td><input type='text' class='form-control form-control-sm' id='product"+i+"' name='product[]'/></td><td><input type='text' class='form-control form-control-sm' id='qty"+i+"' name='qty[]'/></td></tr>";
            $('table').append(data);
            i++;
        });

        function select_all() {
            $('input[class=case]:checkbox').each(function(){
                if($('input[class=check_all]:checkbox:checked').length == 0){
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function check(){
            obj = $('table tr').find('span');
            $.each( obj, function( key, value ) {
                id=value.id;
                $('#'+id).html(key+1);
            });
        }
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
@endsection
