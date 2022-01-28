@extends('layout.mainlayout')
@section('title','Report')
@section('content')

    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="stockin_report" data-toggle="tab" href="#stockin_tab" role="tab" aria-controls="home" aria-selected="true">Daily Stock In</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="stockout_report" data-toggle="tab" href="#stockoutReport" role="tab" aria-controls="profile" aria-selected="false">Daily Stock Out</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="stock_tab" data-toggle="tab" href="#stock_report" role="tab" aria-controls="contact" aria-selected="false">Daily Stock Balance</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id='total_income' data-toggle="tab" href="#revenue" role="tab" aria-controls="contact" aria-selected="false">Daily Revenue</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="expense_tab" data-toggle="tab" href="#expense" role="tab" aria-controls="contact" aria-selected="false">Daily Expense</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Daily Advance Payment</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Daily Deposit</a>
                </li>
            </ul>
        </div>

        <!-- /Page Header -->
        <div class="col-md-12 col-sm-12 col-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="stockin_tab" role="tabpanel" aria-labelledby="home-tab">
                    <table id="stockin" class="table col-12" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product Code</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Warehouse</th>
                            <th>Supplier</th>

                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade " id="stockoutReport" role="tabpanel" aria-labelledby="home-tab">
                    <table id="stockout" class="table dataTable"  style="width: 100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product Code</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Warehouse</th>
                            <th>Customer</th>


                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="revenue" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="col-12">
                        <div class="row justify-content-between">
                            <span>Cash On Hand :{{$total_income[0]->total??0}}</span>
                        </div>
                    </div>
                    <table id="income" class="table col-12" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Account</th>
                            <th>Customer</th>
                            <th>Receiver</th>
                            <th>Approver</th>
                            <th>Transaction Approve</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                    </table>
                    <table class="table" id="summary">
                    </table>
                </div>
                <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="contact-tab">
                    <table id="expense_table" class="table col-12" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Account</th>
                            <th>Supplier</th>
                            <th>Issuer</th>
                            <th>Approver</th>
                            <th>Transaction Approve</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                    </table>
                    <table class="table" id="summary">
                    </table>
                </div>
                <div class="tab-pane fade" id="stock_report" role="tabpanel" aria-labelledby="contact-tab">
                    <table class="table" id="stock_report_table" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product</th>
                            <th>Variants</th>
                            <th>Warehouse</th>
                            <th>Unit</th>
                            <th>Balance</th>
                            <th>Available</th>
                            <th>Last Updated</th>
                        </tr>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
           $('#stock_tab').click(function () {
               $('#stock_report_table').DataTable({
                   dom: 'Bfrtip',
                   buttons: [
                       'copy', 'csv', 'excel', 'pdf', 'print'
                   ],
                   destroy:true,
                   processing: true,
                   serverSide: true,
                   ajax: "{{url('daily/stock/report')}}",
                   columns: [
                       {
                           data:'variant.product_code',
                           name:'Product Code'
                       },
                       {
                           data:'variant.product_name',
                           name:'Product Name'
                       },
                       {
                           data:'variant.variant',
                           name:'Variant'
                       },
                       {
                           data:'warehouse.name',
                           name:'Warehouse'
                       },
                       {
                           data:'unit',
                           name:'Unit'
                       },
                       {
                           data:'stock_balance',
                           name:'Balance'
                       },
                       {
                           data:'available',
                           name:'Available'
                       },
                       {
                           data: 'created_at',
                           name: 'Last Updated'

                       }
                   ]
               });
           });
            $('#stockin_report').click(function () {
                $('#stockin').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    destroy:true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('report.stockin') }}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },
                        {
                            data: 'variant.product_code',
                            name: 'Product Code'
                        },
                        {
                          data:'variant.product_name',
                          name:'Product Name'
                        },
                        {
                            data:'variant.variant',
                            name:'Variant'
                        },
                        {
                            data: 'stockin.qty',
                            name: 'Qty'
                        },
                        {
                            data:'unit',
                            name:'Unit'
                        },
                        {
                          data:'warehouse.name',
                          name:'Warehouse'
                        },
                        {
                            data:'supplier',
                            name:'Supplier'
                        }

                    ]

                });

            });
            $('#stockout_report').click(function(){
                $('#stockout').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    destroy:true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('report.stockout') }}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },
                        {
                            data: 'variant.product_code',
                            name: 'Product Code'
                        },
                        {
                            data:'variant.product_name',
                            name:'Product Name'
                        },
                        {
                            data:'variant.variant',
                            name:'Variant'
                        },
                        {
                            data: 'qty',
                            name: 'Qty'
                        },
                        {
                            data:'unit',
                            name:'Unit'
                        },
                        {
                          data:'stockout.type',
                          name:'Type'
                        },
                        {
                            data:'warehouse.name',
                            name:'Warehouse'
                        },
                        {
                            data:'customer',
                            name:'Customer'
                        }

                    ]


                });


            });
            $('#total_income').click(function () {
                $('#income').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    destroy:true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{url('daily/income/report')}}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },
                        {
                            data:'amount',
                            name:'Amount'
                        },
                        {
                            data: 'account',
                            name: 'Account'
                        },
                        {
                            data:'customer.name',
                            name:'Customer'
                        },
                        {
                            data:'employee.name',
                            name:'Receiver'
                        },
                        {
                            data: 'approver.name',
                            name: 'Approver'
                        },
                        {
                            data:'transaction',
                            name:'Transaction Done'
                        },
                        {
                            data:'category',
                            name:'Type'
                        }


                    ],
                    rows:[
                        {
                            column:[{
                                data:'',
                                name:''
                            }]
                        }
                    ]

                });
            });
            $('#expense_tab').click(function () {
                $('#expense_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    destroy:true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{url('daily/expense/report')}}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },
                        {
                            data:'amount',
                            name:'Amount'
                        },
                        {
                            data: 'account',
                            name: 'Account'
                        },
                        {
                            data:'supplier.name',
                            name:'Supplier'
                        },
                        {
                            data:'employee.name',
                            name:'Issuer'
                        },
                        {
                            data: 'approver.name',
                            name: 'Approver'
                        },
                        {
                            data:'transaction',
                            name:'Transaction Done'
                        },
                        {
                            data:'category',
                            name:'Type'
                        }


                    ],

                });
            });
        });

    </script>
    @endsection
