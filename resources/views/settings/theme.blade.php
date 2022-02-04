@extends('layout.mainlayout')
@section("title",'Theme Color')
@section('content')
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2 card shadow">
<div class="card-header">
    <h4>Theme Color Setting</h4>
</div>
                <form action="{{route('theme.color')}}" class="my-3" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Theme Color</label>
                        <div class="col-lg-9">
                            <select name="theme_id" id="" class="select">
                                @foreach($theme as $color)
                                <option value="{{$color->id}}">{{$color->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection