<x-forms.basic.input name="name" title="Name" value="{{$record->name ?? old('name')}}" required></x-forms.basic.input>
<x-forms.basic.select name="parent_department" title="Parent Department" placeHolder="Choose Parent Department" :options="$parent_departments" value="{{$record->parent_department ?? old('parent_department')}}"></x-forms.basic.select>
<div class="form-group row">
    <label class="col-form-label col-md-2">Department's Head</label>
    <div class="col-md-8">
        <select class="form-control" id="employee_id" name="employee_id">
            <option disabled selected>Choose Department's Head</option>
            @foreach ($employees as $key => $option)
                <option value="{{$key}}" {{$key===($record->departmentHeads[0]->employee_id??'')?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>

        @error('employee_id')
        <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
        @enderror
    </div>
    <div class="col-md-2 add-company">
        <a href="{{route('employees.create')}}" class="btn btn-primary mt-1"><span class='fa fa-plus'></span></a>
    </div>

</div>
<x-forms.basic.textarea name='address' title="Address" value="{{$record->address ?? old('address')}}" :required="false"></x-forms.basic.textarea>
