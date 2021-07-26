<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10">
        @foreach ($options as $key => $option)
            <div class="radio">
                <label for="{{$name . $option}}">
                <input type="radio" id="{{$name . $option}}" name="{{$name}}" value="{{$key}}"
                {{$key === ($value ?? '')? 'checked' : ''}}> {{$option}}
                </label>
            </div>
        @endforeach
    </div>
</div>
