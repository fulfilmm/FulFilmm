@extends('layout.mainlayout')
@section('title','Petty Cash')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Petty Cash</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Petty Cash</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="col-12">
                    <div class="row my-3">
                        <div class="col-12">
                            <h2 class="text-center">Petty Cash Voucher</h2>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-info">{{$petty_cash->status}}</h3>
                                </div>
                               @if($petty_cash->manager_approve==1 && $petty_cash->finance_approve==1)
                                    @if($petty_cash->status!='Clearance')
                                        <div class="col-10">
                                            <form action="{{route('petty_cash.update',$petty_cash->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="1">
                                                <div class="float-left">
                                                    <button type="submit" class="btn btn-primary"> Clearance</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                   @endif
                            </div>
                        </div>
                        <div class="col-md-3 col-12  float-right">
                           <h5 class="text-left text-{{$petty_cash->priority=='High'?'danger':($petty_cash->priority=='Medium'?'info':'primary')}}">Priority :{{$petty_cash->priority}}</h5>
                           <h5 class="text-left">Target Date :{{\Carbon\Carbon::parse($petty_cash->target_date)->toFormattedDateString()}}</h5>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group float-right">
                                <label for="no">
                                    No
                                </label>
                                <input type="text" class="form-control form-control-sm" name="no" id="no" value="{{$petty_cash->no}}"
                                       readonly>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group ">
                                <label for="date">Date :</label>

                                <input type="date" class="form-control" name="date" id="date"
                                       value="{{\Carbon\Carbon::parse($petty_cash->date)->format('Y-m-d')}}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="amount">
                                    Amount
                                </label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                       value="{{$petty_cash->amount}}" readonly>
                            </div>

                        </div>
                    </div>
                    <form action="{{route('petty_cash.update',$petty_cash->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="approver">Approver</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$petty_cash->manager->name}}"
                                               readonly>
                                        <div class="input-group-append">
                                            @if(\Illuminate\Support\Facades\Auth::guard('employee')->user()->id==$petty_cash->manager_id)
                                                @if($petty_cash->manager_approve==1)
                                                    <button type="button" class="btn btn-success"><i
                                                                class="fa fa-check-circle-o"></i> Approved
                                                    </button>
                                                @else
                                                    <input type="hidden" name="approve" value="1">
                                                    <button type="submit" class="btn btn-primary">Approve</button>
                                                @endif

                                            @else
                                                @if($petty_cash->manager_approve)
                                                    <button type="button" class="btn btn-success disabled"><i
                                                                class="fa fa-check-circle-o"></i> Approved
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-primary disabled"> Approve
                                                    </button>

                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="approver">Cashier</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$petty_cash->finance->name}}"
                                               readonly>
                                        <div class="input-group-append">
                                            @if($petty_cash->tag_finance_id==\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                                @if($petty_cash->finance_approve)
                                                    <button type="button" class="btn btn-success disabled"><i
                                                                class="fa fa-check-circle-o"></i> Confirmed
                                                    </button>
                                                @else
                                                    <input type="hidden" name="confirm" value="1">
                                                    <button type="submit" class="btn btn-primary">Confirm</button>
                                                @endif
                                            @else
                                                <button type="button"
                                                        class="btn btn-{{$petty_cash->finance_approve==1?'success':'primary'}} disabled">{{$petty_cash->finance_approve?'Confirmed':'Confirm'}}</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" cols="30" rows="5" class="form-control"
                                          readonly>{{$petty_cash->description}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Petty Cash Expense Details
                </div>
                <form action="{{route('petty_cash.update',$petty_cash->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="add_exp" value="1">
                    <div class="col-12 my-2">
                        <div id="item_table">
                            @if($petty_cash->status!='Clearance')
                                <button type="button" class='delete btn btn-danger btn-sm'>Remove</button>
                                <button type="button" class='addmore btn btn-white btn-sm'>Add New Row</button>

                                <br>
                                <span class="text-danger" style="font-size: 12px;">!If you want to remove row,checked row checkbox and click remove button</span>
                                <br>
                            @endif
                            <table class="table-hover table table-bordered">
                                <tr>
                                    <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Amount</th>
                                </tr>
                                @if(count($items)!=0)
                                    @foreach($items as $item)
                                        <tr>
                                            <td><input type='checkbox' class='case' value="{{$item->id}}" readonly></td>
                                            <td><input type='date' class="form-control form-control-sm" id='product'
                                                       value="{{\Carbon\Carbon::parse($item->date)->format('Y-m-d')}}"
                                                       readonly/>
                                            </td>
                                            <td><input type='text' class="form-control form-control-sm" id='varaiant'
                                                       value="{{$item->purpose}}" readonly></td>
                                            <td><input type='text' class="form-control form-control-sm sub_amount"
                                                       id='amount' value="{{$item->amount}}" readonly></td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if($petty_cash->status!='Clearance')
                                    <tr>
                                        <td><input type='checkbox' class='case' /></td>
                                        <td><input type='date' class="form-control form-control-sm" id='product'
                                                   name='date[]'/></td>
                                        <td><input type='text' class="form-control form-control-sm" id='varaiant'
                                                   name='purpose[]'/></td>
                                        <td><input type='text' class="form-control form-control-sm sub_amount"
                                                   id='amount'
                                                   name='amount[]'></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group float-right">
                                    Issue Amount
                                    <input type="number" class="form-control" value="{{$petty_cash->amount}}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group float-right">
                                    Total Used Amount
                                    <input type="number" class="form-control" id="total" value="{{$total_used}}"
                                           readonly>
                                </div>
                            </div>

                                @if($petty_cash->status=='Clearance')
                                <div class="col-12">
                                    <div class="form-group float-right">
                                        <label for="">Overdraft Amount</label>
                                        <input type="number" class="form-control" id="remaining"
                                               value="{{$petty_cash->remaining}}" readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group float-right">
                                        <label for="">Remaining Amount</label>
                                        <input type="number" class="form-control" id="remaining"
                                               value="0.0" readonly>
                                    </div>
                                </div>
                                @else
                                <div class="col-12">
                                    <div class="form-group float-right">
                                        <label for="">Remaining Amount</label>
                                        <input type="number" class="form-control" id="remaining"
                                               value="{{$petty_cash->remaining}}" readonly>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
            </div>
            @if($petty_cash->status!='Clearance')
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                @endif
                </form>
        </div>
    </div>
    </div>
    <script>
        $(document).keyup(".sub_amount", function () {
            var sum = 0;
            $(".sub_amount").each(function () {
                if ($(this).val() != "")
                    sum += parseInt($(this).val());
            });
            var remaining = parseFloat({{$petty_cash->amount}}) - sum;
            $("#total").val(sum);
            $('#remaining').val(remaining);
        });
        $(".delete").on('click', function () {
            var id = [];
            $('.case:checkbox:checked').each(function () {
                if ($(this).val() !== 'on') {

                    id.push($(this).val())
                }

                $('.case:checkbox:checked').parents("tr").remove();
                $('.check_all').prop("checked", false);
                check();
                $.ajax({
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    url: "{{url('petty/cash/item/delete')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        console.log(data);
                    }
                });
            });

        });
        var i = 2;
        $(".addmore").on('click', function () {
            count = $('table tr').length;
            var data = "<tr><td><input type='checkbox' class='case'/></td>";
            data += "<td><input type='date' class='form-control form-control-sm' id='product" + i + "' name='date[]'/></td> <td><input type='text' class='form-control form-control-sm' id='variant" + i + "' name='purpose[]'/></td><td><input type='text' class='form-control form-control-sm sub_amount' id='amount" + i + "' name='amount[]' /></td></tr>";
            $('table').append(data);
            i++;
        });

        function select_all() {
            $('input[class=case]:checkbox').each(function () {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function check() {
            obj = $('table tr').find('span');
            $.each(obj, function (key, value) {
                id = value.id;
                $('#' + id).html(key + 1);
            });
        }
    </script>
@endsection