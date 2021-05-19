<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10">
        <label for="{{$name}}"></label>
        <select class="form-control" id="{{$name}}" name="{{$name}}" {{($required??true)?'required':''}}>
            <option value="" disabled selected>{{$placeHolder??$title}}</option>
            @foreach ($options as $key => $option)
                <option value="{{$key}}" {{$key==($value??'')?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>
        @error($name)
        <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
        @enderror
    </div>
</div>
