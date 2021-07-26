<div class="modal custom-modal rounded" id="add_user">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Contact</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container " >
                    <div class="modal-body">
                        <div class="col-12">
                            <x-forms.basic.input name="customer_name" title="Name" value="{{$record->name ?? old('name')}}" required></x-forms.basic.input>
                            <x-forms.basic.input name="customer_phone" type="tel" title="Phone" value="{{$record->phone ?? old('phone')}}" required></x-forms.basic.input>
                            <x-forms.basic.input name="customer_email" type="email" title="Email" value="{{$record->email ?? old('email')}}" required></x-forms.basic.input>

                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Customer's Company</label>
                                <div class="col-md-10">
                                    <select class="form-control" id="customer_company_id" name="company_id">
                                        <option disabled selected>Choose Customer's Current Company</option>

                                        @foreach ($companies as $key => $option)
                                            <option value="{{$key}}" {{$key===($record->company_id?? old('company_id'))?'selected':''}}>{{$option}}</option>
                                        @endforeach
                                    </select>

                                    @error('company_id')
                                    <span role="alert">
            <p class="text-danger mt-3 mb-0">{{ $message }}</p>
        </span>
                                    @enderror

                                </div>

                            </div>
                            <x-forms.basic.textarea name='customer_address' title="Address" value="{{$record->address ?? old('address')}}" :required="false"></x-forms.basic.textarea>

                        </div>
                        <div class="form-group text-center">
                    <button class="btn btn-primary" type="button" data-dismiss="modal" id="customer_add">Create</button>
                </div>
                    </div>
            </div>
        </div>
    </div>
</div>
