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
            value="{{ $value ?? old($name) }}"
            {{($required??true)?'required':''}}
            autocomplete="name"
            class="form-control">
        </div>
        @error('name')
        <br>
        <span class="" role="alert">
            <p class="text-danger">{{ $message }}</p>
        </span>
        @enderror
    </div>

    {{-- အခြား element type များဖြစ်သည့် select ကဲ့သို့သော element များ ကို ကိုယ့်ဘာကိုရေးပါ fren --}}

