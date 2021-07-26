@extends('layout.mainlayout')
@section('content')
            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Invoices</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                                <li class="breadcrumb-item active">Invoices</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="{{route('invoices.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Create Invoice</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->
                <form action="{{route('invoices.search')}}" method="POST" id="filter">
                    @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div >
                                <input class="form-control floating " type="datetime-local" name="form_date">
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div>
                                <input class="form-control floating " type="datetime-local" name="to_date">
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus select-focus">
                            <select class="select floating" name="status">
                                <option>Select Status</option>
                                <option>Pending</option>
                                <option>Paid</option>
                                <option>Partially Paid</option>
                            </select>
                            <label class="focus-label">Status</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" href="#" class="btn btn-success btn-block"> Search </button>
                    </div>
                </div>
                </form>
                    <!-- /Search Filter -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Client</th>
                                        <th>Created Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($allinv as $invoice)
                                    <tr>
                                        <td>{{$invoice->id}}</td>
                                        <td><a href="{{route('invoices.show',$invoice->id)}}">#{{$invoice->invoice_id}}</a></td>
                                        <td>{{$invoice->customer->name}}</td>
                                        <td>{{$invoice->created_at->toFormattedDateString()}}</td>
                                        <td>{{\Illuminate\Support\Carbon::parse($invoice->due_date)->toFormattedDateString()}}</td>
                                        <td>{{$invoice->grand_total}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <a class="btn btn-white btn-sm btn-rounded "  href="#" data-toggle="modal" data-target="#change_status{{$invoice->id}}">
                                                    {{$invoice->status}}
                                                </a>
                                            </div>
                                            @include('invoice.inv_statuschange')
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
{{--                                                    <a class="dropdown-item" href="{{route("invoices.edit",$invoice->id)}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>--}}
                                                    <a class="dropdown-item" href="{{route("invoices.show",$invoice->id)}}"><i class="fa fa-eye m-r-5"></i> View</a>
{{--                                                    <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>--}}
                                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#delete{{$invoice->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                     @include('invoice.delete')
                                 @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
{{--                    <iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=Asia%2FYangon&amp;src=Y2luY2luLmNvbUBnbWFpbC5jb20&amp;src=NWpkNG91cWVzNGY5a3NibmwwajB1dmlzY2NAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;src=Ym5nM2dvZGwzOWo5Y29zY2hsaTdsOXF2bzRAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&amp;color=%237986CB&amp;color=%23D50000&amp;color=%23F09300" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>--}}
                </div>
            </div>
            <!-- /Page Content -->
            <script>

            </script>

@endsection
