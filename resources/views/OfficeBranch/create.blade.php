@extends("layout.mainlayout")
@section('title','Office Create')
@section("content")
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Office Branch</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Office Branch</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{route('officebranch.store')}}" method="POST">
                @csrf
                <div class="col-md-8 offset-md-2 card shadow">
                    <div class="row my-5">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="head">Head Office</label>
                                <select name="head_office" id="head" class="form-control">
                                    @foreach($head as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control shadow-sm" value="{{old('name')}}">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="type" value="Branch">
                        {{--<div class="col-12">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="type">Branch Type</label>--}}
                        {{--<select name="type" id="type" class="form-control">--}}
                        {{--<option value="Branch" {{old('type')=='Branch'?'selected':''}}>Branch</option>--}}
                        {{--<option value="Sub-Branch" {{old('type')=='Sub-Branch'?'selected':''}}>Sub Branch Office</option>--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-12" id="reference">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="parent">Parent Branch</label>--}}
                        {{--<select name="parent_branch" id="parent" class="form-control" style="width: 100%">--}}
                        {{--<option value="">Select Parent Branch</option>--}}
                        {{--@foreach($branches as $item)--}}
                        {{--<option value="{{$item->id}}" {{$item->id==old('parent_branch')?'selected':''}}>{{$item->name}}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control shadow-sm" name="address" value="{{old('address')}}" id="location">
                                @error('address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary shadow">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var type=$('#type option:selected').val();
            if(type=='Branch'){
                $('#reference').hide();
            }else if(type=='Sub-Branch'){
                $('#reference').show();
            }
            $('select').select2();
        });
        $(document).on('change','#type',function () {
            var type=$('#type option:selected').val();
            if(type=='Branch'){
                $('#reference').hide();
            }else if(type=='Sub-Branch'){
                $('#reference').show();
            }
        });
    </script>
@endsection