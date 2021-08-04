<x-forms.basic.input name="title" type="text" value="{{$activity->title ?? ''}}" title="Title" required></x-forms.basic.input>
<x-forms.basic.select name="report_to_employee_id" title="Report To" value="{{$activity->report_to_employee_id ?? old('report_to_employee_id')}}"
    :options="$employees" required></x-forms.basic.select>
    
    <div class="form-group row">
        <label class="col-form-label col-md-2">Co Owners</label>
        <div class="col-md-10 w-100" id="co_owners" name="co_owners">
            <select class="form-control" id="co_owner_multiple_select" style="width: 100%" name="co_owners[]"
            multiple="multiple" required>
            @foreach ($employees as $key => $employee)
            
            <option value={{$key}}   
            @isset($activity)
                @if( in_array($key, $activity->co_owner_ids->toArray())) 
                selected 
                @endif
            @endisset>
            {{$employee}} 
        </option>
        @endforeach
        
    </select>
</div>
</div>
<x-forms.basic.date name="date" title="Date" required value="{{isset($activity->date) ? \Carbon\Carbon::parse($activity->date)->format('d/m/Y') : ''}}"></x-forms.basic.date>


@push('scripts')

<script>
    $(document).ready(function () {
        $('#co_owner_multiple_select').select2();
        
    });
</script>
@endpush