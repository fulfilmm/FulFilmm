
<x-forms.basic.input name="name" value="{{$group->name ?? ''}}" title="Name" required></x-forms.basic.input>
<div class="form-group row">
    <label class="col-form-label col-md-2">Employees</label>
    <div class="col-md-10" id="employee" name="employee">
        <select class="js-example-basic-multiple form-control" name="employees[]" multiple="multiple">
            @foreach ($employees as $dept)
            <optgroup label={{$dept->name}}>
                @foreach ($dept->employees as $employee)
                <option value={{$employee->id}}>{{$employee->name}}</option>
                @endforeach

                </optgroup>
            @endforeach

          </select>
    </div>
</div>
