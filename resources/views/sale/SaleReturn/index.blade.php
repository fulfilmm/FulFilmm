@extends("layout.mainlayout")
@section("title","Sales Return")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Sales Return</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sales Return</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn btn-sm shadow-sm"  data-toggle="modal" data-target="#add_new_salereturn" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Sale Return</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3">
                    <table class="table table-nowrap table-nowrap">
                        <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Sale Man</th>
                            <th>Attach</th>
                            <th>Cashier/Accountant</th>
                            <th>Created Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sale_returns as $record)
                            <tr>
                                <td><a href="{{route('invoices.show',$record->invoice->id)}}">{{$record->invoice->invoice_id}}</a></td>
                                <td>{{$record->customer->name}}</td>
                                <td>{{$record->amount??0}}</td>
                                <td>{{$record->saleman->name??''}}</td>
                                <td>@if($record->attach!=null)<a href="{{url(asset('attach_file/'.$record->attach))}}">{{$record->attach}}</a> @else N/A @endif</td>
                                <th>{{$record->cashier->name}}</th>
                                <td>{{$record->created_at->toFormattedDateString()}}</td>
                                <td>{{$record->category}}</td>
                                <td>{{$record->approve?'Approved':'Waiting'}}</td>
                                <td>
                                    <div class="row">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_return{{$record->id}}"><i class="la la-edit"></i></button>
                                        <form action="{{route('expense_record.destroy',$record->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                        </form>
                                        <div id="edit_return{{$record->id}}" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title">Edit Expense</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('sale_return.update',$record->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            @include('sale.SaleReturn.edit')

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        <div id="add_new_salereturn" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title">Add Sale Return</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('sale_return.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('sale.SaleReturn.create')

                        </form>
                    </div>
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