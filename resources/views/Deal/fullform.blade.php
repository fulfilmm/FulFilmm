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
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                    <label for="full_form_name" >Deal Name</label>
                                    <input type="text" id="full_form_name" name="deal_name" value="{{old('deal_name')}}" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_form_amount">Amount</label>
                                    <div class="row">
                                        <div class="col-md-9 col-8">
                                            <input type="number" id="full_form_amount" name="amount" class="form-control">
                                        </div>
                                        <div class="col-4 col-md-3">
                                            <select name="unit" id="full_form_unit" class="select form-control">
                                                <option value="MMK">MMK</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group" >
                                    <label for="full_org" >Organization</label>
                                    <div class="row">
                                        <div class="col-md-9 col-10" id="full_org_div">
                                            <select name="org_name" id="full_org"  class="select" >
                                                @foreach($companies as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button data-toggle="modal" href="#add_company"  class="btn btn-outline-dark col-md-1 col-2" style="width: 20%"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group" id="full_org_div">
                                    <label for="full_contact">Contact Name</label>
                                    <div class="row">
                                        <div class="col-md-9 col-10" id="contact_div">
                                            <select name="contact_name" id="full_contact"   class="select">
                                                @foreach($allcustomers as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button data-toggle="modal" href="#add_user"  class="btn btn-outline-dark col-md-1 col-2" style="width: 20%"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_exp_date" >Expected Close Date</label>
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                            <input type="date" id="full_exp_date" name="exp_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-6 col-12">
                               <label for="full_pipeline">Pipeline</label>
                               <div class="row">
                                   <div class="col-md-9 col-12">
                                       <select name="pipeline" id="full_pipeline" class="select col-md-10" style="width: 85%">
                                           <option value="Standard">Standard</option>
                                       </select>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_sale_stage" >Sale Stage</label>
                                  <div class="row">
                                      <div class="col-md-9 col-12">
                                          <select name="sale_stage" id="full_sale_stage" class="select " style="width: 85%">
                                              <option value="New">New</option>
                                              <option value="Qualified">Qualified</option>
                                              <option value="Quotation">Quatation</option>
                                              <option value="Invoicing">Invoicing</option>
                                              <option value="Win">Negotiation </option>
                                              <option value="Lost">Lost</option>
                                          </select>
                                      </div>
                                  </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_assign_to">Assigned To</label>
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                            <select name="assign_to" id="full_assign_to" class="select">
                                                @foreach($allemployees as $emp)
                                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_lead_source" >Lead Source</label>
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                            <select name="lead_source" id="full_lead_source" class="select">
                                                @foreach($lead_source as $key=>$val)
                                                <option value="{{$val}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="next_step">Next Step</label>
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                    <input type="text" id="next_step" name="next_step" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_type" >Type</label>
                                    <div class="row">
                                    <div class="col-md-9 col-12">
                                        <select name="type" id="full_type" class="select">
                                            <option value="Existing Business">Existing Business</option>
                                            <option value="New Business">New Business</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_probability">Probability</label>
                                    <div class="row">
                                        <div class="col-md-9 col-10">
                                            <input type="number" name="probability" id="full_probability" class="form-control">
                                        </div>
                                            <button type="button" class="btn btn-white col-md-1 col-2">%</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="weight_revenue">Weighted Revenue</label>
                                    <div class="row">
                                        <div class="col-md-9 col-8">
                                            <input type="number" name="revenue" id="weight_revenue" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-4">
                                            <select name="unit" id="revenue_unit" class="select">
                                                <option value="MMK">MMK</option>
                                                <option value="USD">USD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="lost_reason" >Lost Reason</label>
                                    <div class="row">
                                        <div class="col-md-9 col-12">
                                            <select name="deal_name" id="lost_reason" class="select">
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

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                           <label for="description"> Description </label>
                        </div>
                        <div class="col-12 my-1">
                            <textarea name="description" id="description" style="width: 100%" rows="10"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button href="#" data-dismiss="modal" class="btn btn-danger col-2">Close</button>
                    <button href="#" id="full_form_save" class="btn btn-primary col-2">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
       $('full_org').select2();
    });
</script>
