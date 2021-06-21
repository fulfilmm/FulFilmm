<div class="col-12">
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 text-right">Deal Name</label>
            <input type="text" id="deal_name" name="deal_name" class="col-md-6 form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 col-12 text-right">Amount</label>
            <input type="text" name="amount" id="amount" class="col-md-4 col-8 form-control">
            <select name="unit" id="unit" class="col-md-2 col-4">
                <option value="MMK">MMK</option>
                <option value="USD">USD</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="row" id="org_div">
            <label for="" class="col-md-3 col-12 text-right">Organization Name</label>
            <select name="org_name" id="quick_org"  class="col-md-4 col-7 form-control " >
                @foreach($companies as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
{{--            <a data-toggle="modal" href="#orginazation"  class="btn btn-outline-dark col-md-1 col-2"><i class="fa fa-building"></i></a>--}}
            <a data-toggle="modal" href="#add_company"  class="btn btn-outline-dark col-md-1 col-2"><i class="fa fa-plus"></i></a>
            <!-- Modal -->

        </div>
    </div>
    <div class="row">
        <label for="" class="col-md-3 text-right">Expected Close Date</label>
        <div class="form-group col-md-6">
            <div class="">
                <input type="date" id="close_date" name="exp_date" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 text-right">Pipeline</label>
            <select name="deal_name" id="pipeline" class="col-md-6 form-control">
                <option value="Standard">Standard</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 text-right">Sale Stage</label>
            <select name="deal_name" id="sale_stage" class="col-md-6 form-control">
                <option value="New">New</option>
                <option value="Qualified">Qualified</option>
                <option value="Quotation">Quatation</option>
                <option value="Invoicing">Invoicing</option>
                <option value="Win">Negotiation </option>
                <option value="Lost">Lost</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 text-right">Assign To</label>
            <select name="deal_name" id="assign_to" class="col-md-6 form-control">
                @foreach($allemployees as $emp)
                    <option value="{{$emp->id}}">{{$emp->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 text-right">Lead Source</label>
            <select name="deal_name" id="lead_source" class="col-md-6 form-control">
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
    </div>
    <div class="form-group">
        <div class="row">
            <label for="" class="col-md-3 col-12 text-right">Probability</label>
            <input type="number" id="propability" name="propability" class="col-md-5 col-10 form-control">
            <button type="button" class="col-2 col-md-1">%</button>
        </div>
    </div>
    <div class="text-center">
        <a data-toggle="modal" href="#full_form" id="call_full_form" class="btn btn-primary">Full Form</a>
        <button type="button" class="btn btn-danger" id="quick_save">Save</button>
    </div>
</div>

