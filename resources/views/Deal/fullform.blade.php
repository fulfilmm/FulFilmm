<div class="modal custom-modal rounded" id="full_form">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Deal Full Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container scoll" >
                <div class="modal-body">
                    <div class="card col-12">
                        <div class="card-header">
                            Deal Detail
                        </div>
                        <div class="row my-3">
                            <div class="col-md-2">
                                <label for="" >Deal Name</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="full_form_name" name="deal_name" class="form-control col-md-10 col-11">
                            </div>
                            <div class="col-md-2 col-12 mt-3"><label for="">Amount</label></div>
                            <div class="col-md-4">
                                <div class="row col-12">
                                    <input type="number" id="full_form_amount" name="amount" class="form-control col-md-7 col-8">
                                    <select name="unit" id="full_form_unit" class="form-control col-md-4 col-4">
                                        <option value="MMK">MMK</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row my-3">
                            <div class="col-md-2 col-12 mt-3">
                                <label for="" >Organization</label>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="row col-md-12" id="full_org_div">
                                    <select name="org_name" id="full_org"  class="col-md-8" style="width: 60%" >
                                        @foreach($companies as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <a data-toggle="modal" href="#add_company"  class="btn btn-outline-dark col-md-2" style="width: 20%"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-12 mt-3"><label for="">Contact Name</label></div>
                            <div class="col-md-4 col-12">
                                <div class="row col-md-11" id="contact_div" >
                                    <select name="contact_name" id="full_contact"   class=" form-control col-md-8" style="width: 60%" >
                                        @foreach($allcustomers as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    <a data-toggle="modal" href="#add_user"  class="btn btn-outline-dark col-md-2" style="width: 20%"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>

                        </div>
                        <div class="row my-3">
                            <div class="col-md-2 mt-3">
                                <label for="" >Expected Close Date</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="full_exp_date" name="exp_date" class="form-control col-md-10 col-11">
                            </div>
                            <div class="col-md-2 mt-3"><label for="">Pipeline</label></div>
                            <div class="col-md-4">
                                <select name="pipeline" id="full_pipeline" class="form-control " style="width: 85%">
                                    <option value="Standard">Standard</option>
                                </select>
                            </div>

                        </div>
                        <div class="row my-3">
                            <div class="col-md-2 mt-3">
                                <label for="" >Sale Stage</label>
                            </div>
                            <div class="col-md-4">
                                <select name="sale_stage" id="full_sale_stage" class="form-control " style="width: 85%">
                                    <option value="New">New</option>
                                    <option value="Qualified">Qualified</option>
                                    <option value="Quotation">Quatation</option>
                                    <option value="Invoicing">Invoicing</option>
                                    <option value="Win">Negotiation </option>
                                    <option value="Lost">Lost</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3"><label for="">Assigned To
                                </label></div>
                            <div class="col-md-4">
                                <select name="assign_to" id="full_assign_to" class="form-control " style="width: 85%">
                                    @foreach($allemployees as $emp)
                                        <option value="{{$emp->id}}">{{$emp->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-2 mt-3">
                                <label for="" >Lead Source</label>
                            </div>
                            <div class="col-md-4">
                                <select name="lead_source" id="full_lead_source" class="form-control " style="width: 85%">
                                    <option value="Cold Call">Cold Call</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Word of mouth">Word of mouth</option>
                                    <option value="Website">Website</option>
                                    <option value="Trade Show">Trade Show</option>
                                    <option value="Conference">Conference</option>
                                    <option value="Direct Mail">Direct Mail</option>
                                    <option value="Public Relation">Public Relation</option>
                                    <option value="Partner">Partner</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Self Generated">Self Generated</option>
                                    <option value="Existing Customer">Existing Customer</option>
                                    <option value="Facebook">Facebook</option>
                                </select>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="">Next Step</label></div>
                            <div class="col-md-4">
                                <input type="text"id="next_step" name="next_step" class="form-control col-md-10 col-11">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-2 mt-3">
                                <label for="" >Type</label>
                            </div>
                            <div class="col-md-4">
                                <select name="type" id="full_type" class="form-control " style="width: 85%">
                                    <option value="Existing Business">Existing Business</option>
                                    <option value="New Business">New Business</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-12 mt-3">
                                <label for="">Probability</label></div>
                            <div class="col-md-4">
                                <div class="row col-12">
                                    <input type="number" name="probability" id="full_probability" class="form-control col-md-9 col-10">
                                    <button type="button" class="col-md-2 col-2">%</button>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            {{--                                    <div class="col-md-2 mt-3">--}}
                            {{--                                        <label for="" >Campaign Source</label>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-4 col-12">--}}
                            {{--                                        <div class="row col-md-11" id="camp_div">--}}
                            {{--                                            <select name="contact_name" id="camp_source"  class=" form-control col-md-8" style="width: 60%" >--}}
                            {{--                                                @foreach($allcustomers as $client)--}}
                            {{--                                                    <option value="{{$client->id}}">{{$client->customer_name}}</option>--}}
                            {{--                                                @endforeach--}}
                            {{--                                            </select>--}}
                            {{--                                            <a data-toggle="modal" href="#camping"  class="btn btn-outline-dark col-md-2 "style="width: 20%"><i class="fa fa-bullhorn"></i></a>--}}
                            {{--                                            <a data-toggle="modal" href="#add_camp"  class="btn btn-outline-dark col-md-2" style="width: 20%"><i class="fa fa-plus"></i></a>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            <div class="col-md-2 mt-3">
                                <label for="">Weighted Revenue</label></div>
                            <div class="col-md-4">
                                <div class="row col-12">
                                    <input type="number" name="revenue" id="weight_revenue" class="form-control col-md-7 col-8">
                                    <select name="unit" id="revenue_unit" class="form-control col-md-4 col-4">
                                        <option value="MMK">MMK</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="" >Lost Reason</label>
                            </div>
                            <div class="col-md-4">
                                <select name="deal_name" id="lost_reason" class="form-control " style="width: 85%">
                                    <option value="Price">Price</option>
                                    <option value="Authority">Authority</option>
                                    <option value="Timing">Timing</option>
                                    <option value="Missing Feature">Missing Feature</option>
                                    <option value="Usability"> Usability</option>
                                    <option value="Unknown"> Unknown</option>
                                    <option value="No need">No Need</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Decription Detail
                        </div>
                        <div class="mx-3 my-3">
                            <textarea name="description" id="description" style="width: 100%" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">Close</a>
                    <a href="#" id="full_form_save" class="btn btn-primary">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>
