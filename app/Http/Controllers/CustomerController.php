<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\assign_ticket;
use App\Models\Customer;
use App\Models\deal;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\lead_comment;
use App\Models\lead_follower;
use App\Models\next_plan;
use App\Models\OrderItem;
use App\Models\Quotation;
use App\Models\SalePipelineRecord;
use App\Models\tags_industry;
use App\Models\ticket;
use App\Models\ticket_sender;
use App\Repositories\Contracts\CompanyContract;
use App\Repositories\Contracts\CustomerContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    use WithPagination;
    public $state = ['Yangon Division', 'Mandalay Division', 'Bago Division', 'Ayeyarwady Division', 'Tanintharyi Division', 'Magway Division', 'Sagaing Division', 'Kachin State', 'Kayah State', 'Kayin State', 'Chin State', 'Mon State', 'Rakhine State', 'Shan State'];

    private $customerContract, $company_contract;

    public function __construct(CustomerContract $customerContract, CompanyContract $company_contract)
    {
        $this->customerContract = $customerContract;
        $this->company_contract = $company_contract;

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        return view('customer.data.lists');
    }

    public function card()
    {
        $customers = Customer::paginate(12);
        return view('customer.data.cards', compact('customers'));
    }
    public function qualified_contact(){
        $customers = Customer::where('customer_type','Lead')->where('status','Qualified')->paginate(20);
        return view('customer.qualifiedContact', compact('customers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        $state = $this->state;
        $tags = tags_industry::all();
        $last_tag = tags_industry::orderBy('id', 'desc')->first();
        $companies = $this->company_contract->all()->pluck('name', 'id')->all();
        $parent_companies = $this->company_contract->parentCompanies()->pluck('name', 'id')->all();
        return view('customer.create', compact('companies', 'state', 'last_tag', 'tags','parent_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Exception
     */
    public function store(CustomerRequest $request)
    {

        $this->validate($request,['email'=>'unique:customers']);
        if (isset($request->profile_img)) {
            if ($request->profile_img != null) {
                $image = $request->file('profile_img');
                $input['imagename'] = time().'.'.$image->extension();

                $filePath = public_path('/img/profiles');

                $img = Image::make($image->path());
                $img->resize(110, 110, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);

            }
        }
        $data = [
            'profile' => $request->profile_img != null?$input['imagename']:null,
            'name' => $request->name,
            'region' => $request->region,
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
            "emp_id" => Auth::guard('employee')->user()->id,
            'company_id' => $request->company_id,
            'customer_type' => $request->customer_type,
            'department'=>$request->department,
            'position'=>$request->position??null,
            'status'=>$request->status,
            'lead_title'=>$request->title

        ];
        try{
            $this->customerContract->create($data);
            if($request->customer_type=='Lead'){
                $customer=Customer::orderBy('id', 'desc')->first();
                $last_deal=deal::orderBy('id', 'desc')->first();

                if ($last_deal!=null) {
                    // Sum 1 + last id
                    $last_deal->deal_id++;
                    $deal_id = $last_deal->deal_id;
                } else {
                    $deal_id='Deal'."-0001";
                }
                $deal=new deal();
                $deal->deal_id=$deal_id;
                $deal->amount=0;
                $deal->unit="MMK";
                $deal->org_name=$request->company_id;
                $deal->contact=$customer->id;
                $deal->sale_stage=$request->status;
                $deal->lead_title=$request->title;
                $deal->created_id=Auth::guard('employee')->user()->id;
                $deal->save();
                $deal_record=new SalePipelineRecord();
                $deal_record->state=$request->status;
                $deal_record->deal_id=$deal->id;
                $deal_record->emp_id=Auth::guard('employee')->user()->id;
                $deal_record->save();

            }
        return redirect()->route('customers.index')->with('success', __('alert.create_success'));
        }catch (Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('company')->where('id', $id)->firstOrFail();
        $assign_ticket = assign_ticket::with('agent', 'dept')->get();

        $ticket_history = ticket_sender::where('customer_id', $id)->first();

        if ($ticket_history == null) {
            $customer_ticket = [];
        } else {
            $customer_ticket = ticket::with('ticket_status', 'ticket_priority')->where("customer_id", $ticket_history->customer_id)->get();
        }
        $customer_invoice = Invoice::where('customer_id', $id)->get();
        $customer_deal = deal::with("customer_company", "customer", "employee")->where('contact', $id)->get();
        $customer_quotation = Quotation::where('customer_name', $customer->id)->get();
        $grand_total = DB::table("invoices")
            ->select(DB::raw("SUM(grand_total) as total"))
            ->where('customer_id',$id)
            ->get();
        $paid_total = 0;
        $overdue = 0;
        $open_unpaid = 0;
        foreach ($customer_invoice as $invoice) {
            if ($invoice->status == 'Paid') {
                $paid_total = $paid_total + $invoice->grand_total;
            } else{
                $open_unpaid = $open_unpaid + $invoice->grand_total;
            }
        }
        $next_plan = next_plan::where("contact_id", $id)->orderBy('id', 'desc')->get();
//        var_dump($next_plan);
        $data = [
            'customer' => $customer,
            'invoice' => $customer_invoice,
            'tickets' => $customer_ticket,
            'deal' => $customer_deal,
            'quotation.blade.php' => $customer_quotation,
            'paid_total' => $paid_total,
            'overdue' => $overdue,
            'open' => $open_unpaid,
            'activity_schedule' => $next_plan,
            'total_sale'=>$grand_total[0]->total
        ];
        $comments = lead_comment::with("user")->where("contact_id", $id)->get();
        $followers = lead_follower::with("user")->where("contact_id", $id)->get();
        $allemps = Employee::all()->pluck('name', 'id')->all();
        $status_color = ['New' => '#49d1b6', 'Open' => '#e84351', 'Close' => '#4e5450', 'Pending' => '#f0ed4f', 'In Progress' => '#2333e8', 'Complete' => '#18b820', 'Overdue' => '#000'];
      $items=[];
        foreach ($customer_invoice as $item){
            $order_item=OrderItem::with('variant','invoice','unit')->where('inv_id',$item->id)->get();
            foreach ($order_item as $inv_item){
                array_push($items,$inv_item);
            }
        }
        return view('customer.show', compact('data', 'assign_ticket', 'status_color', 'comments', 'followers', 'allemps','items'));
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
        $tags = tags_industry::all();
        $last_tag = tags_industry::orderBy('id', 'desc')->first();
        $record = $this->customerContract->getById($id);
        $companies = $this->company_contract->all()->pluck('name', 'id')->all();
        $state = $this->state;
        return view('customer.edit', compact('record', 'companies', 'state', 'tags', 'last_tag'));
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
        $customer = Customer::where('id', $id)->first();

        if (isset($request->profile_img)) {
            if ($request->profile_img != null) {
                $image = $request->file('profile_img');
                $input['imagename'] = time().'.'.$image->extension();

                $filePath = public_path('/img/profiles');

                $img = Image::make($image->path());
                $img->resize(110, 110, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);

                $image->move(public_path() . '/img/profiles', $input['imagename']);
            }
        }
        if (!$customer->can_login) {
            if ($request->canlogin == 'on') {
                $password = Str::random(8);
            } else {
                $password = null;
            }
            $data = [
                'profile' => isset($request->profile_img) ? $input['imagename'] : $request->oldpic,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'region' => $request->region,
                'gender' => $request->gender,
                'address' => $request->address,
                'password' => $password != null ? Hash::make($password) : null,
                'can_login' => $request->canlogin == 'on' ? 1 : 0,
                'facebook' => $request->facebook,
                'linkedin' => $request->linkedin,
                'dob' => $request->dob,
                'report_to' => $request->report_to,
                'position_of_report_to' => $request->position,
                "priority" => $request->priority,
                "tags_id" => $request->tag_industry,
                "emp_id" => Auth::guard('employee')->user()->id,
                'company_id' => $request->company_id,
                'customer_type' => $request->customer_type,
                'department'=>$request->department,
                'position'=>$request->position??null,
                'status'=>$request->status,
                'lead_title'=>$request->title
            ];
            if ($request->canlogin == 'on') {
                $details = array(
                    'email' => $request->email,
                    'subject' => 'Customer Login Access',
                    'clientname' => $request->name,
                    'password' => $password,
                );
                Mail::send('customerprotal.login_access', $details, function ($message) use ($details) {
                    $message->from('cincin.com@gmail.com', 'Cloudark');
                    $message->to($details['email']);
                    $message->subject($details['subject']);

                });
            }
        } else {
            $data = [
                'profile' => isset($request->profile_img) ? $input['imagename'] : $request->oldpic,
                'name' => $request->name,
                'phone' => $request->phone,
                'region' => $request->region,
                'email' => $request->email,
                'gender' => $request->gender,
                'address' => $request->address,
                'can_login' => $request->canlogin == 'on' ? 1 : 0,
                'facebook' => $request->facebook,
                'linkedin' => $request->linkedin,
                'dob' => $request->dob,
                'report_to' => $request->report_to,
                'position_of_report_to' => $request->position,
                "priority" => $request->priority,
                "tags_id" => $request->tag_industry,
                "emp_id" => Auth::guard('employee')->user()->id,
                'company_id' => $request->company_id,
                'customer_type' => $request->customer_type,
                'department'=>$request->department,
                'position'=>$request->position??null,
                'status'=>$request->status,
                'lead_title'=>$request->title

            ];
        }

        $this->customerContract->updateById($id, $data);
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

    public function export(Request $request)
    {
        return Excel::download(new CustomerExport($request->start_date,$request->end_date), 'customers.xlsx');
    }

    public function import(Request $request)
    {
//        dd($request->all());
        try {
            Excel::import(new CustomerImport, $request->file('import'));
            return redirect()->route('customers.index')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect()->route('customers.index')->with('error', $e->getMessage());
        }

    }
    public function ChangeContactType(Request $request){
//        dd($request->all());
        foreach ($request->customer_id as $customer_id){
            $customer=Customer::where('id',$customer_id)->first();
           if(isset($request->status)){
//               dd('true');
               $customer->status=$request->action_Type;
           }else{
//               dd('false');
               $customer->customer_type=$request->action_Type;
           }
            $customer->update();
        }
    }
    public function supplier(){
        $suppliers=Customer::where('customer_type','Supplier')->get();
        return view('customer.supplier',compact('suppliers'));
    }

}
