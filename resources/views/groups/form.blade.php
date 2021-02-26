
<x-forms.basic.input name="name" value="{{$group->name ?? ''}}" title="Name" required></x-forms.basic.input>
<div class="form-group row">
    <label class="col-form-label col-md-2">Employees</label>
    <div class="col-md-10" id="employee" name="employee">
        <select class="js-example-basic-multiple w-50" name="employees[]" multiple="multiple" required>
            @foreach ($employees as $dept)
            <optgroup label={{$dept->name}}>
                @foreach ($dept->employees as $employee)
                <option value={{$employee->id}} @if($employee->id === \Auth::id()) selected @endif>{{$employee->name}}</option>
                @endforeach

                </optgroup>
            @endforeach

          </select>
    </div>
</div>
