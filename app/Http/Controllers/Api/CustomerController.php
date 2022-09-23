<?php

namespace App\Http\Controllers\Api;

use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\assign_ticket;
use App\Models\Company;
use App\Models\Customer;
use App\Models\deal;
use App\Models\Invoice;
use App\Models\leadModel;
use App\Models\Quotation;
use App\Models\ticket;
use App\Models\ticket_sender;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    private $customerContract, $companyContract;

    public function __construct(CustomerContract $customerContract, CompanyContract $companyContract)
    {
        $this->customerContract = $customerContract;
        $this->companyContract = $companyContract;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
	$auth=Auth::guard('api')->user();
        $customers = Customer::where('region_id',$auth->region_id)->get();
//            ->paginate(20);
        return response()->json(['result'=>$customers,'con'=>true]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        $companies = Company::all();
       return response()->json(['companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CustomerRequest $request)
    {
        //
        $last_customer = Customer::orderBy('id', 'desc')->first();

        if ($last_customer != null) {
            $last_customer->customer_id++;
            $customer_id = $last_customer->customer_id;
        } else {
            $customer_id = "CUS-00001";
        }
        $this->validate($request,['email'=>'unique:customers',
            'customer_id'=>'unique:customers']);
        if (isset($request->profile_img)) {
            if ($request->profile_img != null) {
                $image = $request->file('profile_img');
                $input['imagename'] = Str::random(10).time().'.'.$image->extension();

                $filePath = public_path('/img/profiles');

                $img = Image::make($image->path());
                $img->resize(110, 110, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);

            }
        }
        $data = [
            'customer_id'=>$customer_id,
            'profile' => $request->profile_img != null?$input['imagename']:null,
            'name' => $request->name,
            'branch_id'=>Auth::guard('api')->user()->office_branch_id,
            'zone_id'=>$request->zone_id,
            'region_id' =>Auth::guard('api')->user()->region_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
            'can_login' => 0,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
            'dob' => $request->dob,
            'report_to' => $request->report_to,
            'position_of_report_to' => $request->position,
            "priority" => $request->priority,
            "tags_id" => $request->tag_industry,
            "emp_id" => Auth::guard('api')->user()->id,
            'company_id' => $request->company_id,
            'customer_type' =>isset($request->customer_type)?$request->customer_type:'Customer',
            'department'=>$request->department,
            'position'=>$request->position??null,
            'status'=>$request->status,
            'credit_limit'=>$request->credit_limit??0,
            'lead_title'=>$request->title,
            'use_amount'=>0

        ];
        $this->customerContract->create($data);
        return response()->json(['msg'=>'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();
        $customer=Customer::with('company')->where('id',$id)->first();
        $ticket_history=ticket_sender::where('customer_id',$id)->first();

        if($ticket_history==null){
            $customer_ticket=[];
        }else{
            $customer_ticket= ticket::with('ticket_status', 'ticket_priority')->where("customer_id",$ticket_history->customer_id)->get();
        }
        $customer_invoice=Invoice::where('customer_id',$id)->get();
//        $customer_lead=leadModel::with("saleMan", "tags")->where("created_id",$id)->get();
        $customer_deal=deal::with("customer_company","customer","employee")->where('contact',$id)->get();
        $customer_quotation=Quotation::where('customer_name',$customer->id)->get();
        $paid_total=0;
        $overdue=0;
        $open_unpaid=0;
        foreach ($customer_invoice as $invoice){
            if($invoice->status=='Paid'){
                $paid_total=$paid_total+$invoice->grand_total;
            }elseif ($invoice->status=='Unpaid'&& Carbon::parse($invoice->due_date) > Carbon::now()){
                $overdue=$overdue+$invoice->grand_total;
            }elseif($invoice->status=='Unpaid'){
                $open_unpaid=$open_unpaid+$invoice->grand_total;
            }
        }
        $status_color = ['New' => '#49d1b6', 'Open' => '#e84351', 'Close' => '#4e5450', 'Pending' => '#f0ed4f', 'In Progress' => '#2333e8', 'Complete' => '#18b820', 'Overdue' => '#000'];
        return response()->json([
            'customer'=>$customer,
            'invoice'=>$customer_invoice,
            'tickets'=>$customer_ticket,
            'deal'=>$customer_deal,
            'quotation'=>$customer_quotation,
            'paid_total'=>$paid_total,
            'overdue'=>$overdue,
            'open'=>$open_unpaid,
            'assign_ticket'=>$assign_ticket,
            'status_color'=>$status_color
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $record = $this->customerContract->getById($id);
        $companies = $this->companyContract->all()->pluck('name', 'id')->all();
        return view('customer.edit', compact('record', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //
        $this->customerContract->updateById($id, $request->all());
        return redirect()->route('customers.index')->with('success', __('alerts.update_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        $this->customerContract->deleteById($id);
        return redirect()->route('customers.index')->with('success', __('alert.delete_success'));
    }

    public function export()
    {
        return Excel::download(new CustomerExport, 'customers.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new CustomerImport, $request->file('import'));
            return redirect()->route('customers.index')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect()->route('customers.index')->with('error', $e->getMessage());
        }

    }
}
