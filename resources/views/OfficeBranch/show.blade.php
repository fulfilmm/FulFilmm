@extends("layout.mainlayout")
@section('title','Office Branch')
@section("content")
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Office</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Office Branch</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button type="button" data-toggle="modal" data-target="#add_emp" class="btn btn-primary rounded-pill" >Add Employee</button>
                    <div id="add_emp" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header border-bottom">
                                    <h5 class="modal-title">Add Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('empadd.office')}}" method="post">
                                        @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                           <div class="form-group">
                                               <label for="emp">Employee</label>
                                               <select name="emp_id[]" id="emp" class="form-control select2" multiple style="width: 100%;">
                                                   @foreach($employees as $emp)
                                                       <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                       @endforeach
                                               </select>
                                           </div>
                                        </div>

                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" id="add" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 card shadow">
            <div class="card-header">Office Branch Information</div>
           <div class="row">
               <div class="col-md-6 col-12">
                   <div class="row my-3">
                       <div class="col-md-6 col-6 my-2">Branch Name</div>
                       <div class="col-md-6 col-6 my-2">: {{$branch->name}}</div>
                       <div class="col-md-6 col-6 my-2">Address</div>
                       <div class="col-md-6 col-6 my-2">: {{$branch->address}}</div>
                       <div class="col-md-6 col-6 my-2">Warehouse</div>
                       <div class="col-md-6 col-6 my-2">: {{$branch->warehouse->name}}</div>
                   </div>
               </div>
               <div class="col-md-6 col-12">

               </div>
           </div>
        </div>
        <div class="col-12 card shadow">
          <div class="card-header">
             Office Branch Employees
          </div>
            <table class="table table-hover table-nowrap">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $emp)
                   @if($emp->office_branch_id==$branch->id)
                       <tr>
                           <td>{{$emp->name}}</td>
                           <td>{{$emp->department->name}}</td>
                           <td>{{$emp->role->name}}</td>
                           <td></td>
                       </tr>
                       @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
           $('.select2').select2();
        });
    </script>
@endsection