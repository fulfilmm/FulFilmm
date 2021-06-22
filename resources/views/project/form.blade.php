@if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
@endif
<br>

<form action="{{ route('projects.store') }}" method="POST">
    @csrf
    <x-forms.basic.input name="title" type="text" value="" title="Title" required></x-forms.basic.input>

    <x-forms.basic.select name="proposed_to" title="Proposed To"
                          value="" placeHolder="Please choose one"
                          :options="$employees" required></x-forms.basic.select>

    <x-forms.basic.select name="owner" title="Project Owner"
                          value="" placeHolder="Please choose one"
                          :options="$employees" required></x-forms.basic.select>

    <x-forms.basic.select name="leader" title="Project Leader"
                          value="" placeHolder="Please choose one"
                          :options="$employees" required></x-forms.basic.select>

    <x-forms.basic.date name="start_date" title="Start Date" required value=""></x-forms.basic.date>

    <x-forms.basic.date name="end_date" title="End Date" required value=""></x-forms.basic.date>

    <x-forms.basic.textarea name='description' title="Description" value="" :required="false"></x-forms.basic.textarea>

    <div class="form-group row">
        <label class="col-form-label col-md-2">Priority</label>
        <div class="col-md-10 w-100">
            <select class="form-control" id="priority" name="priority">
                <option value="low" selected>Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
    </div>


    <div class="d-flex justify-content-center">
        <button class="btn btn-primary">Create</button>
        <a href="{{route('departments.index')}}" class="btn btn-secondary ml-3">Cancel</a>
    </div>
</form>
