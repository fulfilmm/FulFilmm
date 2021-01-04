<x-forms.basic.input name="name" title="Name" value="{{$record->name ?? old('name')}}" required></x-forms.basic.input>
<x-forms.basic.input name="phone" type="tel" title="Phone" value="{{$record->phone ?? old('phone')}}" required></x-forms.basic.input>
<x-forms.basic.input name="email" type="email" title="Email" value="{{$record->email ?? old('email')}}" required></x-forms.basic.input>

<div class="form-group row">
    <label class="col-form-label col-md-2">Customer's Company</label>
    <div class="col-md-8">
        <select class="form-control" id="company_id" name="company_id">
            <option disabled selected>Choose Customer's Current Company</option>
            @foreach ($companies as $key => $option)
                <option value="{{$key}}" {{$key===($record->company_id?? old('company_id'))?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>

        @error('company_id')
        <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
        @enderror

    </div>
    <div class="col-md-2 add-company">
        <a href="{{route('companies.create')}}" class="btn btn-primary mt-1"><span class='fa fa-plus'></span></a>
    </div>

</div>
<x-forms.basic.textarea name='address' title="Address" value="{{$record->address ?? old('address')}}" :required="false"></x-forms.basic.textarea>
