<?php

namespace App\Http\Controllers;

use App\Models\CashReceiveRecord;
use App\Models\Employee;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashTransferRecordController extends Controller
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
        $transferrecord=CashReceiveRecord::with('employee','receiver','salemanager','financemanager')->orWhere('emp_id',$auth->id)
            ->orWhere('receiver_id',$auth->id)
            ->orWhere('sale_manager',$auth->id)
            ->orWhere('finance_manager')
            ->get();
        $employee=Employee::where('office_branch_id',$auth->office_branch_id)->get();
        return view('CashTransferRecord.index',compact('transferrecord','employee'));
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
            'emp_id'=>'required',
            'receiver_id'=>'required',
            'sale_manager'=>'required',
            'finance_manager'=>'required',
            'amount'=>'required',
        ]);
        $data=$request->all();
        if ($request->hasfile('attach')) {
            $attach = $request->file('attach');
            $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
            $attach->move(public_path() . '/attach_file/', $input['filename']);
            $dat['attachment'] = $input['filename'];
        }
        CashReceiveRecord::create($data);
        $employee=Employee::where('id',$request->receiver_id)->first();
        $this->addnotify($request->reveiver_id,'noti','Transfer'.$request->amount.' you need to confirm','moneytransfer',Auth::guard('employee')->user()->id);
        $this->addnotify($request->sale_manager,'noti','Transfer'.$request->amount.' to '.$employee->name,'moneytransfer',Auth::guard('employee')->user()->id);
        $this->addnotify($request->finance_manager,'noti','Transfer'.$request->amount.' to '.$employee->name,'moneytransfer',Auth::guard('employee')->user()->id);
        return redirect(route('moneytransfer.index'))->with('success','Add New Cash Transfer Record');
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
        $data=$request->all();
        if ($request->hasfile('attach')) {
            $attach = $request->file('attach');
            $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
            $attach->move(public_path() . '/attach_file/', $input['filename']);
            $dat['attachment'] = $input['filename'];
        }
        $mtfr=CashReceiveRecord::where('id',$id)->first();
        $mtfr->update($data);
        return redirect(route('moneytransfer.index'))->with('success','Updated Cash Transfer Record');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transfer=CashReceiveRecord::where('id',$id)->first();
        $transfer->delete();
        return redirect(route('moneytransfer.index'))->with('success','Deleted Cash Transfer Record');

    }
}
