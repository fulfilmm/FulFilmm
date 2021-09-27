
<div class="row">
    <div class="col-md-4">
        <div class="text-center my-2" >
            <h4>Profile Picture</h4>
            <input type="file" id="file1" accept="image/*" name="profile_img"  class="offset-md-1" onchange="loadFile(event)" style="display:none"/>
            <div>
                <img id="output" onClick="openSelect('#file1')" class="rounded mt-2 mb-4" src="{{isset($employee)?(url(asset($employee->profile_img?'img/profiles/'.$employee->profile_img:'img/profiles/plus.jpg'))):url(asset('/img/profiles/plus.jpg'))}}" width="100px" height="100px;">
                @if(isset($employee))
                    <i class="fa fa-camera mt-5 " style="position: absolute; left: 210px;top: 70px;"></i>
                @endif
            </div>
            <br>

        </div>

    </div>
    <div class="col-md-8">
        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name <span class="text-danger"> * </span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-pencil"></i></span>
                    </div>
                    <x-forms.basic.input name="name" value="{{$record->name ?? old('name')}}" title="Name"
                                         required></x-forms.basic.input>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="business_type" name="business_type">
            <div class="form-group">
                <label for="business_type">Business Type <span class="text-danger"> * </span></label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-building"></i></span>
                    </div>
                    <select name="business_type" class="form-control">
                        <option value="IT">Information Technology</option>
                        <option value="Trading">Trading</option>
                        <option value="Service">Service</option>
                        <option value="Delivery Service">Delivery Service</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone <span class="text-danger"> * </span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    </div>
                    <x-forms.basic.input name="phone" value="{{$record->phone ?? old('phone')}}" icon="phone" title="Phone"
                                         required></x-forms.basic.input>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Mission</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                    </div>
                    <x-forms.basic.input name="mission" value="{{$record->mission ?? old('mission')}}" icon="edit" title="Mission"
                                         required></x-forms.basic.input>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Vision</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-bullseye"></i></span>
                    </div>
                    <x-forms.basic.input name="vision" value="{{$record->vision ?? old('vision')}}" icon="jo" title="Vision"
                                         required></x-forms.basic.input>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <x-forms.basic.input name="email" type="email" value="{{$record->email ?? old('email')}}" icon="" title="Email"
                                         required></x-forms.basic.input>
                </div>
            </div>
        </div>
        </div>
    </div>

</div>
    <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">CEO Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <x-forms.basic.input name="ceo_name" value="{{$record->ceo_name ?? old('ceo_name')}}" icon="user" title="CEO Name"
                                     required></x-forms.basic.input>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Web Link</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-globe"></i></span>
                </div>
                <x-forms.basic.input name="web_link" value="{{$record->web_link ?? old('web_link')}}" icon="globle" title="Web Link"
                                     required></x-forms.basic.input>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Linkedin</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-linkedin-square"></i></span>
                </div>
                <x-forms.basic.input name="linkedin" value="{{$record->linkedin ?? old('linkedin')}}" icon="linkedin"
                                     title="Linkedin"
                                     required></x-forms.basic.input>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Facebook</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-facebook-square"></i></span>
                </div>
        <x-forms.basic.input name="facebook_page" value="{{$record->facebook_page ?? old('facebook_page')}}" icon="facebook"
                             title="Facebook Page" required></x-forms.basic.input>
    </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Company Registry</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-file"></i></span>
                </div>
        <x-forms.basic.input name="company_registry" value="{{$record->company_registry ?? old('company_registry')}}" icon="bilding"
                             title="Company Registry" required></x-forms.basic.input>
    </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="phone">Parent</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-link"></i></span>
                </div>
        @include('forms.select',['name'=>'parent_company', 'title'=>'Parent Company', 'placeHolder' => "Choose Parent Company", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])
    </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="address">Address <span class="text-danger"> * </span></label>
            <textarea name="address" id="address" class="form-control" required>
{{--{{$record->address ?? ''}}--}}
</textarea>
            @error('address')
            <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
            @enderror
        </div>
    </div>

</div>


{{--@include('forms.select',['name'=>'parent_company_2', 'title'=>'Parent Company 2', 'placeHolder' => "Choose Parent Company 2", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])--}}

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




