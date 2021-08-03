<div class="col-12">
    <div class="row">
        <label for="" class="col-md-2 offset-md-1 ">Deal Name<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-12">
            <input type="text" id="deal_name" name="deal_name" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label for="close_date" class="col-md-2 offset-md-1">Expected Close Date<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9  col-12">
                        <input type="date" id="close_date" name="exp_date" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Probability<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
               <div class="row">
                   <div class="col-md-9  col-10">
                       <input type="number" id="propability" name="propability" class="form-control">
                   </div>
                   <button type="button" class="col-2 col-md-2 btn btn-white">%</button>
               </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Amount<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-9">
                        <input type="text" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="col-md-2 col-3">
                        <div class="row">
                        <select name="unit" id="unit" class="select">
                            <option value="MMK">MMK</option>
                            <option value="USD">USD</option>
                        </select>
                        </div>
                    </div>
                <div>

                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="org_div">
        <label for="" class="col-md-2 offset-md-1">Organization Name<span class="text-danger">*</span></label>
        <div class="col-md-6">
          <div class="form-group">
              <div class="row">
              <div class="col-md-9 col-10">
                  <select name="org_name" id="quick_org" class="form-control col-11"   required>
                      @foreach($companies as $key=>$value)
                          <option value="{{$key}}">{{$value}}</option>
                      @endforeach
                  </select>
              </div>
                  <button data-toggle="modal" href="#add_company" title="Add Company" class="btn btn-white col-md-2 col-2 "><i class="fa fa-plus"></i></button>
              </div>
          </div>
        </div>

    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Pipeline<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <select name="deal_name" id="pipeline" class="select" required>
                            <option value="Standard">Standard</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Sale Stage<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <select name="deal_name" id="sale_stage" class="form-control col-11" required>
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
    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Assign To<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <select name="deal_name" id="assign_to" class="form-control col-11" required>
                            @foreach($allemployees as $emp)
                                @if($emp->id!=\Illuminate\Support\Facades\Auth::guard('employee')->user()->id)
                                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
          </div>
      </div>
    </div>
    <div class="row">
        <label for="" class="col-md-2 offset-md-1">Lead Source<span class="text-danger">*</span></label>
        <div class="col-md-6">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <select name="deal_name" id="lead_source" class="form-control col-md-11" required  >
                            @foreach($lead_source as $key=>$val)
                                 <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offset-md-4 offset-2">
    <a data-toggle="modal" href="#full_form" id="call_full_form" class="btn btn-primary">Full Form</a>
    <button type="button" class="btn btn-danger" id="quick_save">Save</button>
</div>
<script>
    $(document).ready(function (){
       $('#lead_source').select2();
    });
    $(document).ready(function (){
        $('#sale_stage').select2();
    });
    $(document).ready(function (){
        $('#assign_to').select2();
    });
    $(document).ready(function (){
        $('#pipeline').select2();
    });
    $(document).ready(function (){
        $('#quick_org').select2();
    });
    $(document).ready(function (){
        $('#unit').select2();
    });
</script>
