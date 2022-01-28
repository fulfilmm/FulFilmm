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
        <div class="col-12">
           <table class="table">
               <thead>
               <tr>
                   <th>Branch Name</th>
                   <th>Address</th>
                   <th>Warehouse</th>
                   <th>Action</th>
               </tr>
               </thead>
               <tbody>
                @foreach($office_branch as $branch)
                    <tr>
                        <td>{{$branch->name}}</td>
                        <td>{{$branch->address}}</td>
                        <td>{{$branch->warehouse->name}}</td>
                        <td>
                            <a href="" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="" class="btn btn-white btn-sm"><i class="la la-edit"></i></a>
                            <a href="" class="btn btn-white btn-sm"><i class="la la-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
               </tbody>
           </table>
        </div>
    </div>
@endsection