@extends("layout.mainlayout")
@section("title","Priority")
@section("content")
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Priority</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/home.blade.php")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Priority</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn"  data-toggle="modal" data-target="#priority" data-whatever="@getbootstrap"><i class="fa fa-plus"></i> Add Priority</a>
                    <button type="button" class="btn btn-outline-secondary mr-2" data-toggle="modal" data-target="#importEmployee">
                        <i class="fa fa-upload mr-2"></i>Import
                    </button>
                    @include('priority.import')
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('priority.create')
        <div class="card">
            <div class="col-md-12 mt-5" style="overflow-x:auto;">
                <table class="table" id="ticket_priority">
                    <thead>
                    <tr>
                        <th scope="col">Priority Name</th>
                        <th scope="col">Color</th>
                        <th scope="col">Duration Time</th>
                        <th scope="col">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($priorities as $priority)
                        <tr>
                            <td><i class="fa fa-bars mr-3"></i> {{$priority->priority}}</td>
                            <td>@if($priority->color=="success")
                                    <a href=""class="btn btn-{{$priority->color}}" style="width: 100px;">Green</a>
                                @elseif($priority->color=="danger")
                                    <a href=""class="btn btn-{{$priority->color}}" style="width: 100px;">Red</a>
                                @elseif($priority->color=="info")
                                    <a href=""class="btn btn-{{$priority->color}}" style="width: 100px;">Blue</a>
                                @elseif($priority->color=="warning")
                                    <a href=""class="btn btn-{{$priority->color}}" style="width: 100px;">Yellow</a>
                                @endif
                            </td>
                            <td>
                                <span>{{$priority->hours}} Hour {{$priority->minutes}} Minutes {{$priority->seconds}} Seconds</span>
                            </td>
                            <td>
                                <div class="dropdown ">
                                    <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th-list"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" data-toggle="modal" data-target="#priority{{$priority->id}}" data-whatever="@getbootstrap"><i class="fa fa-edit mr-2"></i>Edit</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete{{$priority->id}}" data-whatever="@getbootstrap"><i class="fa fa-trash mr-2"></i>Delete</a>
                                    </div>
                                </div>
                                @include('priority.edit')
                                @include('priority.delete')

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
           $("#ticket_priority").DataTable();
        });
    </script>
@endsection
