@extends('layout.mainlayout')
@section('title','Report For'.\Carbon\Carbon::today()->toFormattedDateString())
@section('content')
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->

        <!-- /Page Header -->
        <div class="col-12">

        </div>
        <div class="col-md-12 col-sm-12 col-12 card shadow">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show my-3" id="sale" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">

                </div>
                <div class="tab-pane fade" id="stockin_tab" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">

                </div>
                <div class="tab-pane fade " id="stockoutReport" role="tabpanel" aria-labelledby="home-tab" style="overflow: auto">
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
                <div class="tab-pane fade" id="revenue" role="tabpanel" aria-labelledby="contact-tab" style="overflow: auto">
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
                </div>
                <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="contact-tab" style="overflow: auto">
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
                </div>
                <div class="tab-pane fade" id="stock_report" role="tabpanel" aria-labelledby="contact-tab" style="overflow: auto">
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
                <div class="tab-pane fade" id="advance_pay" role="tabpanel" aria-labelledby="contact-tab" style="overflow: auto">
                    <table class="table" id="advance_payment_table" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Account Name</th>
                            <th>Customer</th>
                            <th>Receiver Employee</th>
                        </tr>

                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sale_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "order": [[ 0, "desc" ]]
            });
        });
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
                           data:'variant.item_code',
                           name:'Item Code'
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
                            data:'supplier',
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
            $('#advance_payment').click(function () {
                $('#advance_payment_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    destroy:true,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('report.advancepay') }}",
                    columns: [{
                        data: 'created_at',
                        name: 'Date'

                    },
                        {
                            data: 'order.order_id',
                            name: 'Order ID'
                        },
                        {
                            data:'amount',
                            name:'Amount'
                        },
                        {
                            data:'type',
                            name:'Type'
                        },
                        {
                            data: 'account',
                            name: 'Account Name.'
                        },
                        {
                            data:'customer.name',
                            name:'Customer'
                        },
                        {
                            data:'emp.name',
                            name:'Receiver'
                        }

                    ]

                });

            });
        });

    </script>
    @endsection
