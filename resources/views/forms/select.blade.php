<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10" id="{{$name}}" name="{{$name}}">
        <select class="form-control">
            <option disabled>{{$placeHolder??$title}}</option>
            @foreach ($options as $key => $option)
                <option value="{{$key}}" {{$key===($value??'')?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>
    </div>
</div>
