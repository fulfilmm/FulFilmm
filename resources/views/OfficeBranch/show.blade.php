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
            </div>
        </div>
        <div class="col-12 card shadow">
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
               <div class="col-md-6 col-12"></div>
           </div>
        </div>
        <div class="col-12 card shadow">
            <h3 class="my-3">Branch Employees</h3>
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
@endsection