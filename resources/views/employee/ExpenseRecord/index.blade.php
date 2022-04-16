@extends("layout.mainlayout")
@section("title","Expense Record")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Expense Record</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Expense Record</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn btn-sm shadow-sm"  data-toggle="modal" data-target="#add_new_expense" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Expense</a>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-3">
                    <table class="table table-nowrap table-nowrap">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Attach</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                           @foreach($emp_expeneses as $record)
                            <tr>
                                <td>{{$record->employee->name}}</td>
                                <td>{{$record->title}}</td>
                                <td>{{$record->amount??0}}</td>
                                <td>{{$record->description??''}}</td>
                                <td><a href="{{url(asset('attach_file/'.$record->attach))}}">{{$record->attach}}</a></td>
                                <td>{{$record->created_at->toFormattedDateString()}}</td>
                                <td>
                                   <div class="row">
                                       <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_expense{{$record->id}}"><i class="la la-edit"></i></button>
                                       <form action="{{route('expense_record.destroy',$record->id)}}" method="post">
                                           @method('DELETE')
                                           @csrf
                                           <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                       </form>
                                       <div id="edit_expense{{$record->id}}" class="modal custom-modal fade" role="dialog">
                                           <div class="modal-dialog modal-dialog-centered modal-md">
                                               <div class="modal-content">
                                                   <div class="modal-header border-bottom">
                                                       <h5 class="modal-title">Edit Expense</h5>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                       </button>
                                                   </div>
                                                   <div class="modal-body">
                                                       <form action="{{route('expense_record.update',$record->id)}}" method="post" enctype="multipart/form-data">
                                                           @csrf
                                                           @method('PUT')
                                                           @include('employee.ExpenseRecord.edit')

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
        <div id="add_new_expense" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <h5 class="modal-title">Add New Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('expense_record.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('employee.ExpenseRecord.create')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @endsection