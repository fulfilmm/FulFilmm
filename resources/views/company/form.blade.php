
<div class="row">
    <div class="col-12 ">
        <div class="card shadow">
           <div class="col-12">
               <div class="row my-3">
                   <div class="col-md-4">
                       <div class="text-center my-2 border shadow-sm" >
                           <h4>Logo</h4>
                           <input type="file" id="file1" accept="image/*" name="logo"  class="offset-md-1" onchange="loadFile(event)" style="display:none"/>
                           <div>
                               <img id="output" onClick="openSelect('#file1')" class="rounded mt-2 mb-4" src="{{isset($record)?($record->logo!=null?$record->logo:'img/profiles/plus.jpg'):url(asset('/img/profiles/plus.jpg'))}}" width="100px" height="100px;">
                               @if(isset($record))
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

                           <div class="col-md-6" id="business_type" >
                               <div class="form-group">
                                   <label for="business_type">Type <span class="text-danger"> * </span></label>

                                   <div class="input-group">
                                       <select name="business_type" class="form-control">
                                           <option value="IT">Information Technology</option>
                                           <option value="Courier">Courier</option>
                                           <option value="Trading">Trading</option>
                                           <option value="Service">Service</option>
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
                                   <label for="phone">Email <span class="text-danger"> * </span></label>
                                   <div class="input-group">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                       </div>
                                       <x-forms.basic.input name="email" type="email" value="{{$record->email?? old('email')}}" icon="" title="Email"
                                                            required></x-forms.basic.input>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12 mb-5">
                               <div class="form-group">
                                   <label for="address">Address</label>
                                   <textarea name="address" id="address" class="form-control" >{{$record->address ?? old('address')}}</textarea>
                                   @error('address')
                                   <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
                                   @enderror
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8 ">
        <div class="card shadow">
            <div class="card-header">
                Others
            </div>
            <div class="col-12">
            <div class="row my-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">CEO Name </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" name="ceo_name" value="{{$record->ceo_name ?? old('ceo_name')}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_registry">Company Registry </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-file"></i></span>
                            </div>
                            <input type="text" is="company_registry" class="form-control" name="company_registry" value="{{$record->company_registry ?? old('company_registry')}}"
                                   title="Company Registry" >
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vision">Vision</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-bullseye"></i></span>
                            </div>
                            <input type="text" id="vision" class="form-control" name="vision" value="{{$record->vision ?? old('vision')}}" icon="jo" title="Vision">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mission">Mission</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-list"></i></span>
                            </div>
                            <input type="text" id='mission' class="form-control" name="mission" value="{{$record->mission ?? old('mission')}}"   title="Mission"  >
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="phone">Parent</label>
                        <div class="input-group">
                            @include('forms.select',['name'=>'parent_company', 'title'=>'Parent Company', 'placeHolder' => "Choose Parent Company", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header">
                Social Media
            </div>
            <div class="col-12">
                <div class="row my-3">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="web_link">Web Link</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                </div>
                                <input type="text" id="web_link" class="form-control" name="web_link" value="{{$record->web_link ?? old('web_link')}}"  title="Web Link">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="linkedin">Linkedin</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-linkedin-square"></i></span>
                                </div>
                                <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{$record->linkedin ?? old('linkedin')}}"
                                       title="Linkedin">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="facebook_page">Facebook</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-facebook-square"></i></span>
                                </div>
                                <input type="text" id="facebook_page" class="form-control" name="facebook_page" value="{{$record->facebook_page ?? old('facebook_page')}}"
                                       title="Facebook Page" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="col-12">
                <button class="btn btn-primary col-12 my-3" type="submit">@if(isset($record))Update @else Create @endif</button>
                <a href="{{route('companies.index')}}" class="btn btn-secondary col-12 mb-3">Cancel</a>
            </div>
        </div>
    </div>
</div>
<script>
    var loadFile = function (event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    function openSelect(file) {
        $(file).trigger('click');
    }
    $(document).ready(function () {
        $('select').select2();
    });
</script>




