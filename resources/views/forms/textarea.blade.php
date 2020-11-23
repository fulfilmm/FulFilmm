<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10">
    <textarea rows="{{$rows ?? 5}}" cols="{{$cols ?? 5}}"
     id="{{$name}}" name="{{$name}}" class="form-control" {{($required??true)?'required':''}}>
     {{$value ?? ''}}
    </textarea>
    </div>
</div>
