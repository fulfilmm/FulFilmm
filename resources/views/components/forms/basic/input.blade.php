
            <input
                id="{{$name}}"
                name="{{$name}}"
                @error($name) is-invalid @enderror
                type="{{$type ?? 'text'}}"
                value="{{ $value ?? old($name) }}"
                {{($required??true)?'required':''}}
                autocomplete="name"
                class="form-control">
        @error($name)
        <br>
        <span class="offset-md-3" role="alert">
            <p class="text-danger">{{ $message }}</p>
        </span>
        @enderror
