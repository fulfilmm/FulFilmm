<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <div class="form-group row">

        <label for="{{$name}}" class="col-form-label col-md-2">{{$title}}</label>
        <div class="col-md-10">
            <div class="cal-icon">
                <input id="{{$name}}"
                       @error($name) is-invalid @enderror name="{{$name}}"
                       value="{{ $value ?? old($name) }}"
                       {{($required??true)?'required':''}}
                       class="form-control floating datetimepicker" type="text">
            </div>
            @error('name')
            <br>
            <span class="" role="alert">
            <p class="text-danger">{{ $message }}</p>
        </span>
            @enderror
        </div>
    </div>
</div>
