<?php

namespace App\Http\Controllers;

use App\Jobs\ExpCliamEmailJob;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\ExpClaimComment;
use App\Models\ExpenseClaim;
use App\Models\ExpenseClaimItem;
use App\Models\TransactionCategory;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseClaimController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='CEO'||$auth->role->name=='SuperAdmin'||$auth->role->name=='Manager') {

            $expense_claim = ExpenseClaim::with('employee', 'approver')->get();
        }else{
            $expense_claim = ExpenseClaim::with('employee', 'approver')->where('emp_id',$auth->id)->orWhere('financial_approver',$auth->id)->get();
        }
        return view('transaction.ExpenseClaim.index',compact('expense_claim'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee=Employee::with('department')->get();
        return view('transaction.ExpenseClaim.create',compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Exception
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
           'description'=>'required',
            'date'=>'required',
            'approver'=>'required',
            'finance_approver'=>'required',
            'amount'=>'required',
            'title'=>'required',
            'total'=>'required'
        ]);
       try {
           $exp_claim = new ExpenseClaim();
           $exp_claim->emp_id = Auth::guard('employee')->user()->id;
           $exp_claim->approver_id = $request->approver;
           $exp_claim->status = 'New';
           $exp_claim->description = $request->description;
           $exp_claim->date = Carbon::create($request->date);
           $exp_claim->is_claim = 0;
           $exp_claim->financial_approver=$request->finance_approver;
           $exp_claim->total=$request->total;
           $exp_claim->tag_emp = json_encode($request->tag);
           if ($request->hasfile('attach')) {
               foreach ($request->file('attach') as $attach) {
                   $name = $attach->getClientOriginalName();
                   $attach->move(public_path() . '/approval_doc/', $name,);
                   $data[] = $name;
               }
               $exp_claim->attach = json_encode($data);
           }
           $exp_claim->save();
           $this->addnotify($request->finance_approver,'success','Request to expense claim.','expenseclaims/'.$exp_claim->id,Auth::guard('employee')->user()->id);
           for($i=0;$i<count($request->title);$i++){
               $item=new ExpenseClaimItem();
               $item->exp_claim_id=$exp_claim->id;
               $item->title=$request->title[$i];
               $item->amount=$request->amount[$i];
               $item->save();
           }
           if($request->tag!=null){
               $creater=Employee::where('id',Auth::guard('employee')->user()->id)->first();
               for ($i=0;$i<count($request->tag);$i++){
                   $employee=Employee::where('id',$request->tag[$i])->first();
                   $details = array(
                       'email' => $employee->email,
                       'subject' => 'New Expense Claim  Notification',
                       'follower_name' => $employee->name,
                       'claim_id'=>$exp_claim->id,
                       'type' => 'follower',
                       'desc' =>$creater->name.' is submit a new expense claim form in'.Carbon::parse($request->date)->toFormattedDateString().' and You are tagged in this form.',
                       'date' => $request->date,
                   );
                   $emailJobs = new ExpCliamEmailJob($details);
                   $this->dispatch($emailJobs);
               }
           }

       }catch (Exception $e){
           return redirect()->route('expenseclaims.index')->with('error', $e->getMessage());
    }
        return redirect(route('expenseclaims.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exp_claim=ExpenseClaim::with('employee','approver','finance_approver')->where('id',$id)->first();
        $items=ExpenseClaimItem::where('exp_claim_id',$id)->get();
        $comment=ExpClaimComment::where('expclaim_id',$id)->get();
        $attach=json_decode($exp_claim->attach);
        return view('transaction.ExpenseClaim.show',compact('exp_claim','items','comment','attach'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function comment(Request $request,$id){
//        dd($request->all());
        $comment=new ExpClaimComment();
        $comment->comment=$request->comment;
        $comment->emp_id=Auth::guard('employee')->user()->id;
        $comment->expclaim_id=$id;
        $comment->save();
        return redirect(route('expenseclaims.show',$id));
    }
    public function commentDelete($id){
        $comment=ExpClaimComment::where('id',$id)->firstorFail();
        $comment->delete();
        return redirect(route('expenseclaims.show',$id));
    }
    public function status($status,$id){
      $exp_claim=ExpenseClaim::where('id',$id)->firstorFail();
      $exp_claim->status=$status;
      $exp_claim->update();
      $this->addnotify($exp_claim->emp_id,'danger',$status.'your expense claim','expenseclaims/'.$exp_claim->id,$exp_claim->financial_approver);
        return redirect(route('expenseclaims.show',$id));
    }
    public function CashClaim($id){
        $exp_claim=ExpenseClaim::where('id',$id)->firstorFail();
        $exp_claim->is_claim=1;
        $exp_claim->update();
        $account=Account::where('enabled',1)->get();
        $recurring=['No','Daily','Weekly','Monthly','Yearly'];
        $payment_method=['Cash','eBanking','WaveMoney','KBZ Pay'];
        $category=TransactionCategory::all();
        $emps=Employee::all();
        $customer=Customer::where('customer_type','Supplier')->get();
        $data=['emps'=>$emps,'customers'=>$customer,'account'=>$account,'recurring'=>$recurring,'payment_method'=>$payment_method,'category'=>$category];
        $this->addnotify($exp_claim->financial_approver,'danger','Has been claimed cash','expenseclaims/'.$exp_claim->id,$exp_claim->emp_id);

        return view('transaction.expense',compact('data','exp_claim'));
    }
}
