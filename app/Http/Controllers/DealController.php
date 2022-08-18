<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Models\deal;
use App\Models\DealActivitySchedule;
use App\Models\DealComment;
use App\Models\Employee;
use App\Models\product;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\SalePipelineRecord;
use App\Models\tags_industry;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    protected $lead_sources=["Cold Call","Referral","Word of mouth","Website",
        "Trade Show","Conference","Direct Mail","Public Relation","Partner",
        "Employee","Self Generated","Existing Customer","Facebook"];
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
            $assigned_deal=deal::with("customer_company","customer","employee")->where("assign_to",$authenticate_user->id)->get();
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
            $allemployees = employee::all();
            $allcustomers = Customer::all();
            $parent_companies=Company::all()->pluck('name', 'id')->all();
            $companies=Company::all()->pluck('name', 'id')->all();
            $lead_source=$this->lead_sources;
        $last_customer = Customer::orderBy('id', 'desc')->first();
        return  view("Deal.create",compact('companies','parent_companies',"allemployees","allcustomers",'lead_source','last_customer'));
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
        $this->validate($request,[
           'name'=>'required',
           'amount'=>'required',
           'unit'=>'required',
            'contact_name'=>'required',
            'exp_date'=>'required',
            'pipeline'=>'required',
            'sale_stage'=>'required',
            'assign_to'=>'required',
            'lead_source'=>'required',
            'probability'=>'required',

        ]);
        $last_deal=deal::orderBy('id', 'desc')->first();

        if ($last_deal!=null) {
            // Sum 1 + last id
                    $last_deal->deal_id++;
                    $deal_id = $last_deal->deal_id;
        } else {
            $deal_id='Deal'."-0001";
        }
        $customer=Customer::where('id',$request->contact_name)->first();
        $deal=new deal();
        $deal->deal_id=$deal_id;
        $deal->name=$request->name;
        $deal->amount=$request->amount;
        $deal->unit=$request->unit;
        $deal->org_name=$customer->company_id;
        $deal->contact=$request->contact_name;
        $deal->close_date=$request->exp_date;
        $deal->pipeline=$request->pipeline;
        $deal->sale_stage=$request->sale_stage;
        $deal->assign_to=$request->assign_to;
        $deal->lead_source=$request->lead_source;
        $deal->next_step=$request->next_step;
        $deal->lead_title=$request->lead_title;
        $deal->type=$request->type;
        $deal->probability=$request->probability;
        $deal->lost_reason=$request->lost_reason;
        $deal->description=$request->description;
        $deal->created_id=Auth::guard('employee')->user()->id;
        $deal->save();
        $deal_record=new SalePipelineRecord();
        $deal_record->state=$request->sale_stage;;
        $deal_record->deal_id=$deal->id;
        $deal_record->emp_id=Auth::guard('employee')->user()->id;
        $deal_record->save();
   return redirect('deals')->with('success','Deal create success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deal=deal::with("customer_company","customer","employee",'created_person')->where("id",$id)->firstOrFail();
        $comments=DealComment::with('user')->where('deal_id',$id)->get();
        $schedules=DealActivitySchedule::where('deal_id',$id)->get();
        return view("Deal.show",compact("deal",'comments','schedules'));
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
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        $allemployees = employee::all();
        $allcustomers = Customer::all()->pluck('name', 'id')->all();
        $companies=Company::all()->pluck('name', 'id')->all();
        $lead_source=$this->lead_sources;
        
        return  view("Deal.edit",compact('parent_companies',"deal", "allemployees",
            "companies","allcustomers",'lead_source'));

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
        $customer=Customer::where('id',$request->contact_name)->first();
        $deal=deal::where("id",$id)->first();
        $deal->name=$request->name;
        $deal->amount=$request->amount;
        $deal->unit=$request->unit;
        $deal->org_name=$customer->company_id;
        $deal->contact=$request->contact_name;
        $deal->close_date=$request->exp_date;
        $deal->pipeline=$request->pipeline;
        $deal->sale_stage=$request->sale_stage;
        $deal->assign_to=$request->assign_to;
        $deal->lead_source=$request->lead_source;
        $deal->next_step=$request->next_step;
        $deal->type=$request->type;
        $deal->probability=$request->probability;
        $deal->lost_reason=$request->lost_reason;
        $deal->description=$request->description;
        $deal->update();
        return redirect('deals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deal=deal::where("id",$id)->first();
        $deal->delete();
        return redirect()->back();
    }
    public function sale_stage_change($status,$id){
        $deal=deal::where("id",$id)->first();
        $deal->sale_stage=$status;
        $deal->update();
        $deal_record=new SalePipelineRecord();
        $deal_record->state=$status;
        $deal_record->deal_id=$deal->id;
        $deal_record->emp_id=$deal->created_id;
        $deal_record->save();
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
    public function comment(Request $request){
        $comments=new DealComment();
        $comments->deal_id = $request->deal_id;
        $comments->user_id = Auth::guard('employee')->user()->id;
        $comments->comment = $request->comment;
        $comments->save();
        return redirect()->back();
    }
    public function schedule(Request $request){
        $schedule=new DealActivitySchedule();
        $schedule->description=$request->description;
        $schedule->to_date=Carbon::create($request->end_date.''.$request->time);
        $schedule->from_date=Carbon::create($request->start_date)->startOfDay();
        $schedule->deal_id=$request->deal_id;
        $schedule->emp_id=Auth::guard('employee')->user()->id;
        $schedule->type=$request->type;
        $schedule->meeting_time=Carbon::create($request->meeting_time.''.$request->time);
        $schedule->work_done=0;
        $schedule->save();
        return redirect()->back();
    }
    public function workdone($id){
        $lead=DealActivitySchedule::where("id",$id)->first();
        $lead->work_done=1;
        $lead->update();
        return redirect()->back();
    }
}
