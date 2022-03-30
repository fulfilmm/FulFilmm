@extends('layout.mainlayout')
@section('title','Bin Look Up')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Bin Look Upd</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Bin Look Up</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow">
                <div class="col-12 my-2">
                    <form action="{{route('binlookup.update',$binlookup->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="bin_no">Bin No</label>
                                    <input type="text" class="form-control" name="bin_no" id="bin_no" value="{{$binlookup->bin_no}}" required>
                                    @error('bin_no')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="width">Width</label>
                                    <input type="text" class="form-control" name="width" id="width" value="{{$binlookup->width}}">
                                    @error('width')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="text" class="form-control" name="height" id="height" value="{{$binlookup->height}}">
                                    @error('height')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="length">Length</label>
                                    <input type="text" class="form-control" name="length" id="length" value="{{$binlookup->length}}">
                                    @error('length')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <textarea name="location" id="location" cols="30" rows="3" class="form-control" >
                                        {{$binlookup->location}}
                                    </textarea>
                                    @error('location')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="description" id="desc" cols="30" rows="3" class="form-control" >
                                       {{$binlookup->description}}
                                    </textarea>
                                    @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection