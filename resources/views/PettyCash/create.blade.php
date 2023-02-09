@extends('layout.mainlayout')
@section('title','Petty Cash')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Advance Cash Create</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Petty Cash</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm bg-grey">
                <form action="{{route('petty_cash.store')}}" method="POST">
                    @csrf
                <div class="col-12">
                    <div class="row my-3">
                        <div class="col-md-12 col-12">
                            <div class="form-group float-right">
                                <label for="no">
                                    No
                                </label>
                                <input type="text" class="form-control" name="no" id="no" value="{{$no}}">
                                @error('no')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group ">
                                <label for="date">Date :</label>

                                <input type="date" class="form-control" name="date" id="date" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                                @error('date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group ">
                                <label for="target_date">Target Date :</label>

                                <input type="date" class="form-control" name="target_date" id="target_date" value="{{\Carbon\Carbon::today()->addDay(1)->format('Y-m-d')}}">
                                @error('target_date')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="amount">
                                    Amount
                                </label>
                                <input type="number" class="form-control" name="amount" id="amount">
                                @error('amount')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select name="priority" id="" class="form-control">
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                                @error('priority')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="approver">Approver</label>
                                <select name="manager_id" id="approver" class="form-control">
                                    @foreach($employees as $emp)
                                      @if($user->department_id==$emp->department_id)
                                            @if($emp->role->name=='CEO'||$emp->role->name=='Sales Manager'||$emp->role->name=='Finance Manager'||
                                        $emp->role->name=='HR Manager'||$emp->role->name=='Stock Manager'||
                                        $emp->role->name=='Customer Service Manager'|| $emp->role->name=='Car Admin')
                                                <option value="{{$emp->id}}">{{$emp->name}}</option>
                                            @endif
                                          @endif
                                        @endforeach
                                </select>
                                @error('manager_id')
                                <span class="text-danger">Approver is required!</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="approver">Cashier</label>
                                <select name="tag_finance_id" id="approver" class="form-control">
                                    @foreach($employees as $emp)
                                        @if($emp->role->name=='Cashier')
                                            <option value="{{$emp->id}}">{{$emp->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('tag_finance_id')
                                <span class="text-danger">Cashier is required!</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="emp_id" value="{{$user->id}}">
                        <input type="hidden" name="status" value="New">
                        <input type="hidden" name="remaining" id="remaining">
                        <div class="col-12">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#amount').keyup(function () {
                var amount=$(this).val();
                $('#remaining').val(amount);
            });
        });
    </script>

        @endsection