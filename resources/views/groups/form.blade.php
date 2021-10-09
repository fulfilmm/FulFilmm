
<div class="form-group row">
    <label class="col-form-label col-md-2">Name</label>
    <div class="col-md-10 w-50">
        <x-forms.basic.input name="name" value="{{$group->name ?? ''}}" title="Name" required></x-forms.basic.input>
    </div>

</div>
<div class="form-group row">
    <label class="col-form-label col-md-2">Tag</label>
    <div class="col-md-10 w-50">
        <x-forms.basic.input name="type" value="{{$group->type ?? ''}}" title="type" required></x-forms.basic.input>
    </div>

</div>
<div class="form-group row">
    <label class="col-form-label col-md-2">Employees</label>
    <div class="col-md-10" id="employee" name="employee">
        <select class="employee_multiple_select w-100" name="employees[]" multiple="multiple" required>
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
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.employee_multiple_select').select2();
        });
    </script>
@endpush
