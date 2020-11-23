<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10">
        <div class="checkbox">
            @foreach ($options as $key => $option)
            <label for="{{$name . $option}}">
                <input type="checkbox" name="{{$name}}[]" id="{{$name . $option}}" value="{{$key}}"> {{$option}}
            </label>
            @endforeach
        </div>
    </div>
</div>
