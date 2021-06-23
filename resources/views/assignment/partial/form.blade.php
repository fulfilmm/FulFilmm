<x-forms.basic.input name="title" type="text" value="{{$assignment->title ??''}}" title="Title" required></x-forms.basic.input>

<div class="form-group row">
    <label class="col-form-label col-md-2">Assign Group</label>
    <div class="col-md-10 w-100" id="co_owners">
        <select class="form-control" id="groups_multiple_select" style="width: 100%" name="assigned_group[]"
        multiple="multiple">
        @foreach ($groups as $key => $group_name)
        <option value={{$key}}  
            @isset($assignment)
                @if( in_array($key, $assignment->group_ids->toArray())) 
                    selected 
                @endif
            @endisset
        >{{$group_name}} </option>
        @endforeach
        
    </select>
</div>
</div>

<div class="form-group row">
    <label class="col-form-label col-md-2">Assign to</label>
    <div class="col-md-10 w-100" id="co_owners">
        <select class="form-control" id="employees_multiple_select" style="width: 100%" name="assigned_employee[]"
        multiple="multiple">
        @foreach ($employees as $key => $employee)
        <option value={{$key}} 
            @isset($assignment)
                @if( in_array($key, $assignment->employee_ids->toArray())) 
                selected 
                @endif
            @endisset>
        {{$employee}} 
    </option>
    @endforeach
    
</select>
</div>
</div>
{{-- {{in_array($key, $assignment->employee_ids->toArray())}} --}}

<x-forms.basic.date name="due_date" title="Due Date" required="true" value="{{isset($assignment->due_date) ? \Carbon\Carbon::parse($assignment->due_date)->format('d/m/Y') : ''}}"></x-forms.basic.date>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#employees_multiple_select').select2();
        $('#groups_multiple_select').select2();
    });
</script>
@endpush