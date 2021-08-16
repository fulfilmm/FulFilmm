
<x-forms.basic.input name="name" value="{{$record->name ?? ''}}" title="Name" required></x-forms.basic.input>

<div class="form-group row">
    <label class="col-form-label col-md-2">Business Type</label>
    <div class="col-md-10" id="business_type" name="business_type">
        <select name="business_type" class="form-control">
            <option value="tech">Tech</option>
        </select>
    </div>
</div>


<x-forms.basic.input name="address" value="{{$record->address ?? ''}}" title="Address" required></x-forms.basic.input>
<x-forms.basic.input name="phone" value="{{$record->phone ?? ''}}" title="Phone" required></x-forms.basic.input>
<x-forms.basic.input name="mission" value="{{$record->mission ?? ''}}" title="Mission" required></x-forms.basic.input>

<x-forms.basic.input name="vision" value="{{$record->vision ?? ''}}" title="Vision" required></x-forms.basic.input>
<x-forms.basic.input name="email" type="email" value="{{$record->email ?? ''}}" title="Email" required></x-forms.basic.input>
<x-forms.basic.input name="ceo_name" value="{{$record->ceo_name ?? ''}}" title="CEO Name" required></x-forms.basic.input>

<x-forms.basic.input name="web_link" value="{{$record->web_link ?? ''}}" title="Web Link" required></x-forms.basic.input>
<x-forms.basic.input name="linkedin" value="{{$record->linkedin ?? ''}}" title="Linkedin" required></x-forms.basic.input>
<x-forms.basic.input name="facebook_page" value="{{$record->facebook_page ?? ''}}" title="Facebook Page" required></x-forms.basic.input>
<x-forms.basic.input name="company_registry" value="{{$record->company_registry ?? ''}}" title="Company Registry" required></x-forms.basic.input>

@include('forms.select',['name'=>'parent_company', 'title'=>'Parent Company', 'placeHolder' => "Choose Parent Company", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])
@include('forms.select',['name'=>'parent_company_2', 'title'=>'Parent Company 2', 'placeHolder' => "Choose Parent Company 2", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])

{{--@if(!$hasSetUp)--}}

{{--<div class="form-group row">--}}
    {{--<label class="col-form-label col-md-2">Current Company</label>--}}
    {{--<div class="col-md-10">--}}
        {{--<div class="checkbox">--}}
            {{--<label for="user_company">--}}
                {{--<input type="checkbox" name="user_company" id="user_company" value='1'>--}}
            {{--</label>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

{{--@endif--}}




