<div class="form-group">
    <label for="name">Name</label>
    <div class="input-group">
        <x-forms.basic.input name="name" title="Name" value="{{$record->name ?? old('name')}}" required></x-forms.basic.input>

    </div>
</div>
<div class="form-group">
    <label for="">Parent Department</label>
    <div class="input-group">
        <x-forms.basic.select name="parent_department" title="Parent Department" placeHolder="Choose Parent Department" :required="false" :options="$parent_departments" value="{{$record->parent_department ?? old('parent_department')}}"></x-forms.basic.select>

    </div>
</div>
<div class="form-group ">
    <label for="employee_id">Department's Head</label>
    <div class="input-group">
        <select class="form-control" id="employee_id" name="employee_id">
            <option disabled selected>Choose Department's Head</option>
            @foreach ($employees as $key => $option)
                <option value="{{$key}}" {{$key===($record->departmentHeads[0]->employee_id??'')?'selected':''}}>{{$option}}</option>
            @endforeach
        </select>
        <a href="{{route('employees.create')}}" class="btn btn-primary text-center"><span class='fa fa-plus '></span></a>
        @error('employee_id')
        <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
        @enderror
    </div>
    {{--<div class="col-md-2 add-company">--}}
        {{----}}
    {{--</div>--}}

</div>
<script>
    $(document).ready(function () {
        $('select').select2();
    });
</script>

