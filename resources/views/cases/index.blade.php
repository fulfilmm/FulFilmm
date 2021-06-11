@extends("layout.mainlayout")
@section("title","Cases Type")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Case Type</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home.blade.php")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Complain Type</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#case_type" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Complain Type</a>
                    <button type="button" class="btn btn-outline-secondary mr-2" data-toggle="modal" data-target="#importEmployee">
                        <i class="fa fa-upload mr-2"></i>Import
                    </button>
                  @include('cases.import')

                </div>
            </div>
        </div>
        <!-- /Page Header -->

       @include('cases.create')
        <div class="card">
            <div class="card-header card-header-danger">
                <h4 class="text-dark"><i class="fa fa-list-alt mr-2"></i>Cases</h4>
            </div>
            <div class="col-12" style="overflow-x: auto">
                <table class="table " id="case">
                    <thead>
                    <tr>
                        <th scope="col">Case Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($case_types as $case)
                        <tr>
                            <td><i class="fa fa-bars mr-3"></i>{{$case->name}}
                            </td>
                            <td>
                                <div class="dropdown ">
                                    <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th-list"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="" class="dropdown-item" data-toggle="modal" data-target="#case{{$case->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit mr-2"></i>Edit</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete{{$case->id}}"><i class="fa fa-trash mr-2"></i>Delete</a>
                                    </div>

                                   @include('cases.edit')
                                    @include('cases.delete')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
           $("#case").DataTable();
        });
    </script>
@endsection
