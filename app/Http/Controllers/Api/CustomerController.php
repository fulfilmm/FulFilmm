<?php

namespace App\Http\Controllers\Api;

use App\Exports\CustomerExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Imports\CustomerImport;
use App\Models\assign_ticket;
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
        $customers = Customer::paginate(20);
        return response()->json(['customer'=>$customers]);
    }

    public function card(){
        $customers = Customer::paginate(20);
        return view('customer.data.cards', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        //
        $companies = $this->companyContract->all()->pluck('name', 'id')->all();
        return view('customer.create', compact('companies'));
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
        $this->customerContract->create($request->all());
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
        $customer_lead=leadModel::with("saleMan", "tags")->where("created_id",$id)->get();
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
        $data=[
            'customer'=>$customer,
            'invoice'=>$customer_invoice,
            'tickets'=>$customer_ticket,
            'lead'=>$customer_lead,
            'deal'=>$customer_deal,
            'quotation.blade.php'=>$customer_quotation,
            'paid_total'=>$paid_total,
            'overdue'=>$overdue,
            'open'=>$open_unpaid
        ];
        $status_color = ['New' => '#49d1b6', 'Open' => '#e84351', 'Close' => '#4e5450', 'Pending' => '#f0ed4f', 'In Progress' => '#2333e8', 'Complete' => '#18b820', 'Overdue' => '#000'];
        return response()->json(['data'=>$data,'assign_ticket'=>$assign_ticket,'status_color'=>$status_color]);
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
