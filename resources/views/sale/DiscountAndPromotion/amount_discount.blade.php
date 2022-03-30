@extends("layout.mainlayout")
@section('title','Amount Discount')
@section("content")
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Amount Discount</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{url("/discount_promotions")}}">Amount Discount</a></li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <button data-toggle="modal" data-target="#add_new" class="btn btn-white float-right mr-3 mt-3 border-dark rounded-pill" style="box-shadow: white"><i class="fa fa-plus mr-2"></i>Add New</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Min Amount</th>
                    <th>Max Amount</th>
                    <th>Rate</th>
                    <th></th>

                </tr>
                </thead>
                <tbody>
                @foreach($discount as $item)
                    <tr>
                        <td>{{$item->description??'N/A'}}</td>
                        <td>{{$item->start_date!=null?\Carbon\Carbon::parse($item->start_date)->toFormattedDateString():'N/A'}}</td>
                        <td>{{$item->end_date!=null?\Carbon\Carbon::parse($item->end_date)->toFormattedDateString():'N/A'}}</td>
                        <td>{{$item->min_amount}}</td>
                        <td>{{$item->max_amount}}</td>
                        <td>{{$item->rate}} %</td>
                        <td>{{$item->sale_type}}</td>
                        <td>
                            <div class="row">
                                <button data-toggle="modal" data-target="#edit_{{$item->id}}" class="btn btn-success btn-sm"><i class="la la-edit"></i></button>
                                <form action="{{route('discount.destroy',$item->id)}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="la la-trash"></i></button>
                                </form>
                            </div>
                            <div id="edit_{{$item->id}}" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title">Add New Discount</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('discount.update',$item->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            <div class="col-md-6" >
                                                                <div class="form-group">
                                                                    <label for="sale_type">Sale Type <span class="text-danger"> * </span></label>
                                                                    <select name="sale_type" class="form-control">
                                                                        <option value="Whole Sale" {{$item->sale_type=='Whole Sale'?'selected':''}}>Whole Sale</option>
                                                                        <option value="Retail Sale" {{$item->sale_type=='Retail Sale'?'selected':''}}>Retail Sale</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="desc">Description</label>
                                                                    <input type="text" class="form-control" name="description" id="desc" value="{{$item->description}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="date">Start Date</label>
                                                                    <input type="date" id="date" class="form-control" name="start_date" title="Start Date" value="{{\Carbon\Carbon::parse($item->start_date)->format('Y-m-d')}}">

                                                                    @error('start_date')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="end_date">End Date</label>
                                                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{\Carbon\Carbon::parse($item->end_date)->format('Y-m-d')}}">
                                                                    @error('end_date')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="min_amount">Min Amount <span class="text-danger"> * </span></label>
                                                                    <input type="number" id="min_amount" name="min_amount" class="form-control" value="{{$item->min_amount}}">
                                                                    @error('min_amount')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="max_amount">Max Amount <span class="text-danger"> * </span></label>
                                                                    <input type="number" id="max_amount" name="max_amount" class="form-control" value="{{$item->max_amount}}">
                                                                    @error('max_amount')
                                                                    <span class="text-danger">{{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="rate">Rate</label>
                                                                    <div class="input-group">
                                                                        <input type="number" class="form-control" name="rate" value="{{$item->rate}}">
                                                                        <div class="input-group-append">
                                                                            <button type="button" class="btn btn-white">%</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit"  class="btn btn-primary">Update</button>
                                                </div>
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
    <div id="add_new" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Add New Discount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('discount.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="sale_type">Sale Type <span class="text-danger"> * </span></label>
                                            <select name="sale_type" class="form-control">
                                                <option value="Whole Sale">Whole Sale</option>
                                                <option value="Retail Sale">Retail Sale</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <input type="text" class="form-control" name="description" id="desc" value="{{old('description')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Start Date</label>
                                            <input type="date" id="date" class="form-control" name="start_date" title="Start Date" value="{{old('start_date')}}">

                                            @error('start_date')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{old('end_date')}}">
                                            @error('end_date')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_amount">Min Amount <span class="text-danger"> * </span></label>
                                            <input type="number" id="min_amount" name="min_amount" class="form-control" value="{{old('min_amount')}}">
                                            @error('min_amount')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_amount">Max Amount <span class="text-danger"> * </span></label>
                                            <input type="number" id="max_amount" name="max_amount" class="form-control" value="{{old('max_amount')}}">
                                            @error('max_amount')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="rate">Rate</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="rate" value="{{old('rate')}}">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-white">%</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="form-group text-center">
                            <button type="submit"  class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection