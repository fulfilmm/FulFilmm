@include('forms.dynamic-input',['name'=>'name', 'title'=>'Name', 'value' => $record->name ?? ''])
@include('forms.select',['name'=>'parent_department', 'title'=>'Parent Department', 'placeHolder' => "Choose Parent Department", 'options' => $parent_departments, 'value' => $record->parent_department ?? ''])

<div class="form-group row">
    <label class="col-form-label col-md-2">Department's Head</label>
    <div class="col-md-8">
        <select class="form-control" id="employee_id" name="employee_id">
            <option disabled selected>Choose Customer's Current Company</option>
            @foreach ($employees as $key => $option)
                <option value="{{$key}}" {{$key===($record->employee_id??'')?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 add-company">
        <a href="{{route('employees.create')}}" class="btn btn-primary mt-1"><span class='fa fa-plus'></span></a>
    </div>

</div>
@include('forms.textarea', ['name' => 'address', 'title' => 'Address', 'value' => $record->address ?? '', 'required' => false])
