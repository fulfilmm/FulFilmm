<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ExpCliamEmailJob;
use App\Models\Employee;
use App\Models\ExpenseClaim;
use App\Models\ExpenseClaimItem;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
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
        $expclaim=ExpenseClaim::with('employee','approver','finance_approver','items')->get();
        return response()->json(['result'=>$expclaim,'con'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
//            'description'=>'required',
            'date'=>'required',
            'approver'=>'required',
            'finance_approver'=>'required',
            'main_title'=>'required',
            'total'=>'required',
            'items'=>'required',
        ]);
        try {
            $exp_claim = new ExpenseClaim();
            $exp_claim->title = $request->main_title;
            $exp_claim->emp_id = Auth::guard('api')->user()->id;
            $exp_claim->approver_id = $request->approver;
            $exp_claim->status = 'New';
            $exp_claim->description = $request->description;
            $exp_claim->date = Carbon::create($request->date);
            $exp_claim->is_claim = 0;
            $exp_claim->financial_approver = $request->finance_approver;
            $exp_claim->total = $request->total;
            $exp_claim->tag_emp = $request->tag;
            if ($request->hasfile('attach')) {
                foreach ($request->file('attach') as $attach) {
                    $input['filename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $attach->extension();
                    $attach->move(public_path() . '/approval_doc/', $input['filename']);
                    $data[] = $input['filename'];
                }
                $exp_claim->attach = json_encode($data);
            }
            $items=json_decode($request->items);
            return response()->json(['date'=>$items]);
            $exp_claim->save();
            $this->addnotify($request->finance_approver, 'success', 'Request to expense claim.', 'expenseclaims/' . $exp_claim->id, Auth::guard('api')->user()->id);
            $this->addnotify($request->approver, 'success', 'Request to expense claim.', 'expenseclaims/' . $exp_claim->id, Auth::guard('api')->user()->id);

            for ($i = 0; $i < count($items); $i++) {
                $item = new ExpenseClaimItem();
                $item->exp_claim_id = $exp_claim->id;
                $item->title = $items[$i]->title;
                $item->amount = $items[$i]->amount;
                $item->save();
            }
            if ($request->tag != null) {
                $creater = Employee::where('id', Auth::guard('api')->user()->id)->first();
                for ($i = 0; $i < count($request->tag); $i++) {
                    $employee = Employee::where('id', $request->tag[$i])->first();
                    $details = array(
                        'email' => $employee->email,
                        'subject' => 'New Expense Claim  Notification',
                        'follower_name' => $employee->name,
                        'claim_id' => $exp_claim->id,
                        'type' => 'follower',
                        'desc' => $creater->name . ' is submit a new expense claim form in' . Carbon::parse($request->date)->toFormattedDateString() . ' and You are tagged in this form.',
                        'date' => $request->date,
                    );
                    $emailJobs = new ExpCliamEmailJob($details);
                    $this->dispatch($emailJobs);
                }
            }
            return response()->json(['con'=>true,'msg'=>'Successful']);
        }catch (\Exception $e){
            return response()->json(['con'=>false,'result'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
