{{-- <div class="card"> <div class="card-header"> <div class="card-body"> --}}

    {{-- အပေါ်က class ၃ခု နှင့်တွဲသုံလေ့ရှိသည်။ --}}


    <div class="form-group row">
        <label for="{{$name}}" class="col-form-label col-md-2">{{$title}}</label>
        <div class="col-md-10">
            <input
            id="{{$name}}"
            name="{{$name}}"
            @error($name) is-invalid @enderror name="{{$name}}"
            type="{{$type ?? 'text'}}"
            value="{{ $value }}"
            {{($required??true)?'required':''}}
            autocomplete="name"
            class="form-control">

            @error($name)
            <span role="alert">
                <p class="text-danger mt-3 mb-0">{{ $message }}</p>
            </span>
            @enderror
        </div>

    </div>

    {{-- အခြား element type များဖြစ်သည့် select ကဲ့သို့သော element များ ကို ကိုယ့်ဘာကိုရေးပါ fren --}}

