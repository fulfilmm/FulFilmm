@extends('layout.mainlayout')
@section('title','Transfer')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Bank Transfer</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transfer</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="col-12 my-5">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-4 text-right my-2">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12 offset-md-0 offset-sm-0 offset-8 my-2">
                            <input type="date" class="form-control" name="date" value="{{\Illuminate\Support\Carbon::now()->format('Y-m-d')}}">
                        </div>
                        <div class="col-md-2 col-sm-3 col-4 text-right my-2">
                            <label for="from_account">From Account :</label>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12 offset-md-0 offset-sm-0 offset-8 my-2">
                            <select name="from_account" id="from_account" class="form-control">
                                <option value="">Select Account</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 col-4 text-right my-2">
                            <label for="to_account">To Account</label>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12 offset-md-0 offset-sm-0 offset-8 my-2">
                            <select name="from_account" id="to_account" class="form-control">
                                <option value="">Select Account</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3 col-4 text-right my-2">
                            <label for="amount">Amount</label>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12 offset-md-0 offset-sm-0 offset-8 my-2">
                            <input type="number" class="form-control" name="amount">
                        </div>
                        <div class="col-md-2 col-sm-3 col-4 text-right my-2">
                            <label for="desc">Description</label>
                        </div>
                        <div class="col-md-9 col-sm-8 col-12 offset-md-0 offset-sm-0 offset-8 my-2">
                            <textarea name="description" id="desc" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Transfer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
