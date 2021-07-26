<div class="form-group row">
    <label class="col-form-label col-md-2">{{$title}}</label>
    <div class="col-md-10">
        <div class="checkbox">
            {{-- {{dd($insertedData->contains('activity_tasks.createe'))}} --}}
            @foreach ($options as $key => $option)
            <label for="{{$name . $option}}">
                <input type="checkbox" {{$insertedData->contains($key)? 'checked' : ''}}  name="{{$name}}[]" id="{{$name . $option}}" value="{{$key}}"> {{$option}}
            </label>
            @endforeach
        </div>
    </div>
</div>
