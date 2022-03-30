@extends('layout.mainlayout')
@section('title','Bin Look Up')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Inventory</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('purchase_request.index')}}">Inventory</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12" style="overflow: auto">
            <table class="table-hover table table-nowrap">
                <thead>
                    <tr>
                        <th>Bin No</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Width</th>
                        <th>Height</th>
                        <th>Length</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($binlookup as $item)
                    <tr>
                        <td>{{$item->bin_no}}</td>
                        <td>{{$item->location}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->width}}</td>
                        <td>{{$item->height}}</td>
                        <td>{{$item->length}}</td>
                        <td>
                          <div class="row">
                              <a href="{{route('binlookup.edit',$item->id)}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></a>
                              <form action="{{route('binlookup.destroy',$item->id)}}" method="post">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                              </form>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection