<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\deal;
use App\Models\Employee;
use App\Models\product;
use App\Models\products_category;
use App\Models\products_tax;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{

    private $customerContract, $company_contract;
    public function __construct(CustomerContract $customerContract, CompanyContract $company_contract)
    {
        $this->customerContract = $customerContract;
        $this->company_contract = $company_contract;
    }

    public function index()
    { $authenticate_user =Auth::guard('employee')->user();
        if ($authenticate_user->role->name=="Employee" || $authenticate_user->role->name=="TicketAdmin") {
            $alldeals=[];
            $assigned_deal=deal::with("customer_company","customer","employee")->where("assign_to",$authenticate_user->employee->id)->get();
            foreach ($assigned_deal as $deal){
                if($deal->created_id!=$authenticate_user->id){
                    array_push($alldeals,$deal);
                }
            }
            $created_deal=deal::with("customer_company","customer","employee")->where("created_id",$authenticate_user->id)->get();
            foreach ($created_deal as $created){
                if(!in_array($created->deal_id, $alldeals)){
                    array_push($alldeals,$created);
                }
            }
        }else{
            $alldeals=deal::with("customer_company","customer","employee")->get();
        }
        return  view("Deal.index",compact("alldeals",));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $hasSetUp = $this->company_contract->isUserCompany();
            $allemployees = employee::all();
            $allcustomers = Customer::all()->pluck('name', 'id')->all();
            $parent_companies=Company::all()->pluck('name', 'id')->all();
            $companies=Company::all()->pluck('name', 'id')->all();
            $taxes=products_tax::all();
            $lasttax=products_tax::orderBy('id', 'desc')->first();
            $allcat=products_category::all();
             $lastcat=products_category::orderBy('id', 'desc')->first();
            $products=product::with("category","taxes")->get();
        return  view("Deal.create",compact("products",'hasSetUp','companies','parent_companies',"taxes","lasttax","lastcat","allcat","lasttax","allemployees","allcustomers"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        if($request->form_type=="quick"){
            $this->quick_store($request->all());
        }else{
            $this->full_form($request->all());

        }
   return redirect('deals');
    }
    public function quick_store($data){
        $deal=new deal();
        $deal->name=$data['name'];
        $deal->amount=$data['amount'];
        $deal->unit=$data['currency'];
        $deal->org_name=$data['org_name'];
        $deal->close_date=Carbon::create($data['close_date']);
        $deal->pipeline=$data['pipeline'];
        $deal->sale_stage=$data['sale_stage'];
        $deal->assign_to=$data['assign_to'];
        $deal->lead_source=$data['lead_source'];
        $deal->probability=$data['propability'];
        $deal->created_id=Auth::guard('employee')->user()->id;
        $deal->save();
    }
    public function full_form($data){
        $deal=new deal();
        $deal->name=$data['name'];
        $deal->amount=$data['amount'];
        $deal->unit=$data['unit'];
        $deal->org_name=$data['full_org'];
        $deal->contact=$data['contact'];
        $deal->close_date=$data['exp_date'];
        $deal->pipeline=$data['pipeline'];
        $deal->sale_stage=$data['sale_stage'];
        $deal->assign_to=$data['asign_to'];
        $deal->lead_source=$data['lead_source'];
        $deal->next_step=$data['next_step'];
        $deal->type=$data['type'];
        $deal->probability=$data['probability'];
        $deal->weighted_revenue=$data['weight_revenue'];
        $deal->weighed_revenue_unit=$data['revenue_unit'];
        $deal->lost_reason=$data['lost_reason'];
        $deal->description=$data['description'];
        $deal->created_id=Auth::guard('employee')->user()->id;
        $deal->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deal=deal::with("customer_company","customer","employee",'created_person')->where("id",$id)->first();
        return view("Deal.show",compact("deal"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deal=deal::where('id',$id)->first();
        $hasSetUp = $this->company_contract->isUserCompany();
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        $allemployees = employee::all();
        $allcustomers = Customer::all();
        $companies=Company::all()->pluck('name', 'id')->all();
        $taxes=products_tax::all();
        $lasttax=products_tax::orderBy('id', 'desc')->first();
        $allcat=products_category::all();
        $lastcat=products_category::orderBy('id', 'desc')->first();
        $products=product::with("category","taxes")->get();
        $sale_stage=['New','Qualifying','Requirement Gathering','Value Position','Negotiation','Closed Won','Closed Lost','Dormant','Ready To CLose'];
        $lead_sources=["Cold Call","Referral","Word of mouth","Website","Trade Show","Conference","Direct Mail",
                        "Public Relation","Partner","Employee","Self Generated","Existing Customer","Facebook"];
        $lost_reason=["Price","Authority","Timing","Missing Feature","Usability","Unknown","No need"];
        return  view("Deal.edit",compact('hasSetUp','parent_companies',"products","deal",
            "taxes","lasttax","lastcat","allcat","lasttax","allemployees",
            "companies","allcustomers",'sale_stage','lead_sources','lost_reason'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
//        dd($id);
        $deal=deal::where("id",$id)->first();
        $deal->name=$request->deal_name;
        $deal->amount=$request->amount;
        $deal->unit=$request->unit;
        $deal->org_name=$request->org_name;
        $deal->contact=$request->contact_name;
        $deal->close_date=$request->exp_date;
        $deal->pipeline=$request->pipeline;
        $deal->sale_stage=$request->sale_stage;
        $deal->assign_to=$request->assign_to;
        $deal->lead_source=$request->lead_source;
        $deal->next_step=$request->next_step;
        $deal->type=$request->type;
        $deal->probability=$request->probality;
        $deal->weighted_revenue=$request->revenue;
        $deal->weighed_revenue_unit=$request->revenue_unit;
        $deal->lost_reason=$request->lost_reason;
        $deal->description=$request->description;
        $deal->update();
        return redirect('deals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deal=deal::where("id",$id)->first();
        $deal->delete();
        return redirect("deal")->with("message","$deal->name Delete Successful");
    }
    public function sale_stage_change(Request $request){
        $deal=deal::where("id",$request->deal_id)->first();
        $deal->sale_stage=$request->sale_stage;
        $deal->update();
        return redirect()->back();
    }
    public function company_create(CompanyRequest $request){
        $this->company_contract->create($request->all());
        return response()->json([
            'company_create' => "success",
        ]);
    }
    public function add_newcustomer(CustomerRequest $request){
        $this->customerContract->create($request->all());
        return response()->json([
            'contact_create' => "success",
        ]);
    }
}
