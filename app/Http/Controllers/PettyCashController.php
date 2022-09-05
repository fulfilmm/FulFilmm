<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\PettyCash;
use App\Models\PettyCashExpItem;
use App\Models\TransactionCategory;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PettyCashController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::guard('employee')->user();
      if($user->role->name=='CEO'||$user->role->name=='Super Admin'){
          $petty_cashes=PettyCash::with('manager','finance','employee')->get();
      }else{
          $petty_cashes=PettyCash::with('manager','finance','employee')->orWhere('emp_id',$user->id)->orWhere('manager_id',$user->id)->orWhere('tag_finance_id',$user->id)->get();
      }
        return view('PettyCash.index',compact('petty_cashes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_no = PettyCash::orderBy('id', 'desc')->first();

        if ($last_no != null) {
            $last_no->no++;
            $no = $last_no->no;
        } else {
            $no = "PTC-00001";
        }
        $user=Auth::guard('employee')->user();
        $admin_ceo=Employee::all();
        $employees=[];
//        Employee::where('office_branch_id',$user->office_branch_id)->get();
        foreach ($admin_ceo as $admin){
            if($admin->role->name=='CEO'||$admin->role->name=='Super Admin'){
                array_push($employees,$admin);
            }
            if ($admin->office_branch_id==$user->office_branch_id){
                array_push($employees,$admin);
            }
        }

        return view('PettyCash.create',compact('employees','no','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'manager_id'=>'required',
            'tag_finance_id'=>'required',
            'date'=>'required',
            'no'=>'required',
            'amount'=>'required',
            'target_date'=>'required',
            'priority'=>'required'
        ]);
        PettyCash::create($request->all());
        return redirect(route('petty_cash.index'))->with('success','Petty Cash Submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd('hello');
        $user=Auth::guard('employee')->user();
        $petty_cash=PettyCash::with('manager','finance','employee')->where('id',$id)->firstOrFail();
        $total_used_exp = DB::table("petty_cash_exp_items")
            ->select(DB::raw("SUM(amount) as total"))
            ->where('petty_cash_id',$id)
            ->get();
        $total_used=$total_used_exp[0]->total??0;
        $items=PettyCashExpItem::where('petty_cash_id',$id)->get();
        if($petty_cash->emp_id==$user->id || $petty_cash->tag_finance_id==$user->id||$petty_cash->manager_id==$user->id){
            return view('PettyCash.show',compact('petty_cash','total_used','items'));
        }else{
            return redirect()->back()->with('error','Sorry,Your not relative this petty cash');
        }

    }


    /**whe
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=Auth::guard('employee')->user();
        $employees=Employee::where('office_branch_id',$user->office_branch_id)->get();
        $petty_cash=PettyCash::where('id',$id)->firstOrFail();
        if($user->id==$petty_cash->manager_id||$user->id==$petty_cash->tag_finance_id||$user->id==$petty_cash->emp_id){
            return view('PettyCash.edit',compact('employees','user','petty_cash'));
        }else{
            return redirect()->back()->with('error','Your not relative this petty cash');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd(isset($request->approve));
        $user=Auth::guard('employee')->user();
        $petty_cash=PettyCash::where('id',$id)->firstOrFail();
        if(isset($request->add_exp)){

            for($i=0;$i<count($request->amount);$i++){
                $data['date']=$request->date[$i];
                $data['purpose']=$request->purpose[$i];
                $data['amount']=$request->amount[$i];
                $data['petty_cash_id']=$id;
                PettyCashExpItem::create($data);
            }
            $total_used_exp = DB::table("petty_cash_exp_items")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('petty_cash_id',$id)
                ->get();
            $petty_cash->remaining-=$total_used_exp[0]->total;
            $petty_cash->update();
        }elseif (isset($request->status)){
            $account=Account::where('enabled',1)->get();
            $recurring=['No','Daily','Weekly','Monthly','Yearly'];
            $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
            $category=TransactionCategory::all();
            $emps=Employee::all();
            $customer=Customer::where('customer_type','Supplier')->get();
            $total_used_exp = DB::table("petty_cash_exp_items")
                ->select(DB::raw("SUM(amount) as total"))
                ->where('petty_cash_id',$id)
                ->get();
            $use_amount=$total_used_exp[0]->total;
//        $coas=ChartOfAccount::all();
            $data=['emps'=>$emps,'customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
            return view('transaction.Expense.create',compact('data','petty_cash','use_amount'));
        }elseif (isset($request->approve)){
//            dd('approve');
            if($user->id==$petty_cash->manager_id){
                $petty_cash->manager_approve=1;
                $petty_cash->update();
            }
        }elseif (isset($request->confirm)){
//            dd('confirm');
            if($user->id==$petty_cash->tag_finance_id){
                $petty_cash->finance_approve=1;
                $petty_cash->update();
            }
        }else{
            $petty_cash->update($request->all());
        }
        return redirect(route('petty_cash.show',$id))->with('success','Updated Successful');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petty_cash=PettyCash::where('id',$id)->firstOrFail();
        $petty_cash->delete();
        return redirect(route('petty_cash.index'))->with('success','Deleted Petty Cash');

    }
    public function item_delete(Request $request){
        foreach ($request->id as $id){
            $item=PettyCashExpItem::where('id',$id)->firstOrFail();
            $item->delete();
        }
        return response()->json(['status'=>'Successful']);
    }

}
