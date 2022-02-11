@extends('layout.mainlayout')
@section('title','Cash Receive')
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Cash Receive</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Cash Receive</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <form action="{{route('payment_receives.store')}}" method="POST">
                    @csrf
                    <div class="col-12 my-3 ">
                        <div class="form-group">
                            <label for="customer">Customer Name</label>
                            <select name="customer_id" id="customer" class="form-control">
                                @foreach($customer as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="receive_date" id="date">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Cash">Cash</option>
                                <option value="Ebanking">AYAmbanking</option>
                                <option value="KBZ Pay">KBZ Pay</option>
                                <option value="WaveMoney">WaveMoney</option>
                                <option value="CB Pay">CB Pay</option>
                            </select>
                        </div>
                        <input type="hidden" name="emp_id"
                               value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->id}}">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{route('payment_receives.index')}}" type="reset" class="btn btn-primary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection