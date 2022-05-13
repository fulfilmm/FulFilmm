@extends('layout.mainlayout')
@section('title','Create Sale Ways')
@section('content')
    <!-- Page Wrapper -->

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Sales Ways</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Sales Ways</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow">
                @error('branch_id')
                <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>You did not connect any office branch!</strong>
                    @enderror
            </div>

                <div class="col-12">
                    <form action="{{route('saleway.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="branch_id" value="{{\Illuminate\Support\Facades\Auth::guard('employee')->user()->office_branch_id??''}}">

                        <div class="form-group">
                            <label for="id">Way ID</label>
                            <input type="text" class="form-control" name="way_id" id="id">
                            @error('way_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Way Name (Optional)</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="shop">Shop</label>
                            <select name="shop_id[]" id="shop" class="form-control" multiple>
                                @foreach($shops as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
               $('select').select2();
            });
        </script>
    </div>
    <!-- /Page Content -->

    <!-- /Page Wrapper -->

@endsection