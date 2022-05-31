@extends('layout.mainlayout')
@section('title','Account')
@section('content')
    <div class="content container-fluid content-layout">
        <div class="page-header mt-2">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Account</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Account</li>
                    </ul>
                </div>
                <div class="text-right mr-3"><a href="{{route('accounts.create')}}"
                                                class="btn btn-success btn-sm">Add New</a></div>
            </div>
        </div>
        <div class="card shadow">
            <div class="col-12 my-5" style="overflow: auto">
                <table class="table table-striped custom-table" id="account">
                    <thead>
                    <tr>
                        <th>Account No</th>
                        <th >
                            Name</th>
                        <th>Bank Account
                            Number</th>
                        <th >Current
                            Balance</th>
                        <th>Account Type</th>
                        <th>Head Office</th>
                        <th>Branch Office</th>
                        <th >Enabled</th>
                        <th style="width: 100px">Actions</th>
                    </tr>

                    </thead>
                    <tbody>
                    {{--                        @dd($account)--}}
                    @foreach($account as $acc)
                        <tr>
                            <th>{{$acc->account_no??''}}</th>
                            <td >
                                <a href="{{route('accounts.show',$acc->id)}}">{{$acc->name}}</a></td>
                            <td >{{$acc->number}}</td>
                            <td>{{number_format($acc->balance)}}
                            </td>
                            <td>{{$acc->head_account?'Head Account':'Branch Account'}}</td>
                            <td>{{$acc->head->name??'N/A'}}</td>
                            <td>{{$acc->branch->name??'N/A'}}</td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="enabled_{{$acc->id}}" name="enable" {{$acc->enabled==1?'checked':''}}>
                                    <label class="custom-control-label" for="enabled_{{$acc->id}}"></label>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $('#enabled_{{$acc->id}}').on('click',function (event) {
                                            if($(this).prop("checked") == true){
                                                var enable=1;
                                            }
                                            else if($(this).prop("checked") == false){
                                                var enable=0;
                                            }
                                            $.ajax({
                                                data: {
                                                    "enable": enable
                                                },
                                                type: 'POST',
                                                url: "{{route('account.enable',$acc->id)}}",
                                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                success: function (data) {
                                                    console.log(data);
                                                    swal({
                                                            title: "Account",
                                                            text: 'This account is '+data.Account,
                                                            type: "success"
                                                        }
                                                    ).then(function(){
                                                        location.reload();
                                                    });

                                                }
                                            });
                                        });
                                    });
                                </script>
                            </td>
                            <td>
                                <a href="{{route('accounts.show',$acc->id)}}" class="btn btn-white btn-sm"><i class="la la-eye"></i></a>
                                <a href="{{route('accounts.edit',$acc->id)}}" class="btn btn-white btn-sm"><i class="la la-edit"></i></a>
                                <a href="" class="btn btn-danger btn-sm " data-toggle="modal" data-target="#delete_{{$acc->id}}"><i class="la la-trash "></i></a>
                                <div id="delete_{{$acc->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Approval</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('accounts.destroy',$acc->id)}}" method="POST" >
                                                    @csrf
                                                    @method('delete')
                                                    <span class="text-danger">Are you sure delete this account?</span>
                                                    <button type="button" class="btn btn-primary btn-sm">No</button>
                                                    <button type="submit" class="btn btn-danger btn-sm">Yes</button>
                                                </form>
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
        <div class="notifications"><span mode="out-in"></span></div>
        <form id="form-dynamic-component" method="POST" action="#"></form> <!---->
        <footer class="footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="text-sm float-left text-muted footer-texts">
                        Powered By Cloudark</div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="text-sm float-right text-muted footer-texts">
                        Version 1.0.0
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            $('#account').DataTable();
            $('.dataTables_filter input').remove('form-control');
            $('.dataTables_filter input').addClass('rounded');
        });
    </script>
@endsection