@extends('layout.mainlayout')
@section('title','Petty Cash')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Petty Cash</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Petty Cash</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Issuer</th>
                                <th>Manager</th>
                                <th>Finance Tag</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Finance Status</th>
                                <th>Manager Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($petty_cashes as $item)
                            <tr>
                                <td><strong>{{$item->no}}</strong></td>
                                <td>{{\Carbon\Carbon::parse($item->date)->toFormattedDateString()}}</td>
                                <td>{{$item->employee->name}}</td>
                                <td>{{$item->manager->name}}</td>
                                <td>{{$item->finance->name}}</td>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->finance_approve?'Confirm':'UnConfirmed'}}</td>
                                <td>{{$item->manager_approve?'Approve':'Not Approved'}}</td>
                                <td style="width: 120px;">
                                  <div class="row">
                                      @if($item->status!='Clearance')
                                          <form action="{{route('petty_cash.destroy',$item->id)}}" method="POST">
                                              @method('delete')
                                              @csrf
                                              <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                          </form>
                                          <a href="{{route('petty_cash.edit',$item->id)}}" class="btn btn-success btn-sm ml-2 mr-2"><i class="fa fa-edit"></i></a>
                                      @endif
                                      <a href="{{route('petty_cash.show',$item->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i></a>
                                  </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
