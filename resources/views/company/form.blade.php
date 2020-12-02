
                            @include('forms.dynamic-input',['name'=>'name', 'title'=>'Name', 'value' => $record->name ?? '', 'required' =>true])
                            @include('forms.dynamic-input',['name'=>'address', 'title'=>'Address', 'value' => $record->address ?? '', 'required' =>true])
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Business Type</label>
                                <div class="col-md-10" id="business_type" name="business_type">
                                    <select name="business_type" class="form-control">
                                            <option value="tech">Tech</option>
                                    </select>
                                </div>
                            </div>

                            @include('forms.dynamic-input',['name'=>'phone', 'title'=>'Phone', 'value' => $record->phone ?? '' , 'type' => 'number','required' =>true])
                            @include('forms.dynamic-input',['name'=>'mission', 'title'=>'Mission', 'value' => $record->mission ?? ''])
                            @include('forms.dynamic-input',['name'=>'vision', 'title'=>'Vision', 'value' => $record->vision ?? ''])
                            @include('forms.dynamic-input',['name'=>'email', 'title'=>'Email', 'value' => $record->email ?? '', 'type' => 'email'])
                            @include('forms.dynamic-input',['name'=>'ceo_name', 'title'=>'CEO name', 'value' => $record->ceo_name ?? ''])
                            @include('forms.dynamic-input',['name'=>'web_link', 'title'=>'Web link', 'value' => $record->web_link ?? ''])
                            @include('forms.dynamic-input',['name'=>'linkedin', 'title'=>'Linkedin', 'value' => $record->linkedin ?? ''])
                            @include('forms.dynamic-input',['name'=>'facebook_page', 'title'=>'Facebook Page', 'value' => $record->facebook_page ?? ''])
                            @include('forms.dynamic-input',['name'=>'company_registry', 'title'=>'Company Registry', 'value' => $record->company_registry ?? ''])
                            @include('forms.select',['name'=>'parent_company', 'title'=>'Parent Company', 'placeHolder' => "Choose Parent Company", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])
                            @include('forms.select',['name'=>'parent_company_2', 'title'=>'Parent Company 2', 'placeHolder' => "Choose Parent Company 2", 'options' => $parent_companies, 'value' => $record->parent_companies ?? ''])
                           




