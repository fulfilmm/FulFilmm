@extends('layout.mainlayout')

@section('name', 'Lead')

@section('content')

    <!-- Page Header -->
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Lead</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{route('customers.create')}}" class="btn add-btn shadow-sm"><i class="fa fa-plus"></i> Add Lead</a>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="form-group col-md-4 col-12 float-right" id="action">
                    <label for="">Action</label>
                    <div class="input-group">
                        <select name="type" id="status" class="form-control">
                            <option value="New">New</option>
                            <option value="Qualified">Qualified</option>
                            <option value="Unqualified">Unqualified</option>
                        </select>
                        <button type="button" id="status_change" class="btn btn-primary"><i class="fa fa-save"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap datatable mb-0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td><input type="checkbox" class="checkbox" name="customer" value="{{$customer->id}}"></td>
                                <td><img src="{{$customer->profile!=null? url(asset('img/profiles/'.$customer->profile)):url(asset('img/profiles/avatar-01.jpg'))}}" alt="" class="avatar chat-avatar-sm">{{$customer->name}}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->company->name }}</td>
                                <td>{{$customer->status}}</td>
                                <td style="display: flex">
                                    <a class="btn btn-success" href="{{route('customers.show',$customer->id)}}"><span class='fa fa-eye'></span></a>&nbsp;
                                    <a class="btn btn-success" href="{{route('customers.edit',$customer->id)}}"><span class='fa fa-edit'></span></a>&nbsp;
                                    <form action="{{route('customers.destroy',$customer->id)}}" id="del-customer{{$customer->id}}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit" onclick="deleteRecord({{$customer->id}})"><span class='fa fa-trash'></span></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {
            $('#action').hide();
            // $('input[type="checkbox"]').click(function () {
            //     $('input[type="checkbox"]').click(function () {
            //         var checked_id = new Array();
            //         $("input:checked").each(function () {
            //             // console.log($(this).val()); //works fine
            //             checked_id.push($(this).val());
            //         });
            //         if (checked_id.length > 0) {
            //             $('#action').show();
            //         } else {
            //             $('#action').hide();
            //         }
            //
            //     });
            // });
            $('.checkbox').on('click',function () {
                if($('.checkbox').is(':checked')){
                    $('#action').show();
                }else {
                    $('#action').hide();
                }
            });
        });
        $(document).ready(function() {
            $(document).on('click', '#status_change', function () {
                var checked_id = new Array();
                $("input:checked").each(function () {
                    // console.log($(this).val()); //works fine
                    checked_id.push($(this).val());
                });
                var action_type=$( "#status option:selected" ).val();
                // alert(action_type);
                $.ajax({
                    type:'POST',
                    data : {
                        action_Type:action_type,
                        customer_id:checked_id,
                        status:'status_change'
                    },
                    url:'change/contact/type',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        console.log(data);
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endsection


