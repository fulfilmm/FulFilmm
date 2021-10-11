<?php

namespace App\Http\Controllers;

use App\Models\approval_comment;
use App\Models\Approvalrequest;
use App\Models\Cc_of_approval;
use App\Models\Customer;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     protected $approval_status=['Approve','Reject','Pending'];
    public function index()
    {

        $auth=Auth::guard('employee')->user();
        $approvals=Approvalrequest::with('approver','secondary_approver','request_emp')->where('emp_id',$auth->id)->get();
        $cc_approvals=Cc_of_approval::where('emp_id',$auth->id)->get();
        $cc=[];
        foreach ($cc_approvals as $cc_approval) {
            $approval_request=Approvalrequest::with('approver','secondary_approver','request_emp')->where('id',$cc_approval->approval_id)->first();
            array_push($cc,$approval_request);
        }
        return  view('approval.index',compact('approvals','cc'));
    }
    public function request_to_me(){
        $auth=Auth::guard('employee')->user();
        $approvals=Approvalrequest::with('approver','secondary_approver','request_emp')->orWhere('approved_id',$auth->id)->orWhere('secondary_approved',$auth->id)->get();
        return view('approval.request_to_me',compact('approvals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_emp=Employee::all();
        $customer=Customer::all();
        return view('approval.create',compact('all_emp','customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'doc_file.*' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip,png|max:2048',
            'description'=>'required',
            'title'=>'required',
            'target_date'=>'required',
        ]);
        //        dd($request->all());
        $last_approval=Approvalrequest::orderBy('id', 'desc')->first();
        if (isset($last_approval)) {
            // Sum 1 + last id
            $last_approval->approval_id ++;
            $approval_id = $last_approval->approval_id;
        } else {
            $approval_id="ID"."-0001";
        }
        $approval=new Approvalrequest();
        $approval->approval_id=$approval_id;
        $approval->title=$request->title;
        $approval->target_date=Carbon::create($request->target_date);
        $approval->content=$request->description;
        $approval->approved_id=$request->approve_id;
        $approval->from_date=$request->from??null;
        $approval->to_date=$request->to_date??null;
        $approval->type=$request->type;
        $approval->amount=$request->type=='Procurement'?$request->procurement_amount:($request->type=='Business Trip'?$request->budget:($request->type=='Payment'?$request->payment_amount:null));
        $approval->location=$request->location??'';
        $approval->contact_id=$request->type=='Payment'?$request->contact:$request->supplier;
        $approval->quantity=$request->quantity??'';
        if($request->members!=null){
            $trip_member=json_encode($request->members);
        }
        $approval->trip_members=$trip_member??null;
        $approval->emp_id=Auth::guard('employee')->user()->id;
        if($request->hasfile('doc_file')) {
            foreach ($request->file('doc_file') as $doc_file) {
                $name = $doc_file->getClientOriginalName();
                $doc_file->move(public_path() . '/approval_doc/', $name);
                $data[] = $name;
            }
            $approval->doc_file=json_encode($data);
        }
        if(isset($request->secondary_id)){
            $approval->secondary_approved=$request->secondary_id;
        }
        $approval->save();
        $approver=Employee::where('id',$request->approve_id)->first();
        if($approver!=null){
            $details = [
                'from'=>Auth::guard('employee')->user()->email,
                'email' => $approver->email,
                'subject' => 'Approval Request',
                'request_name' =>ucfirst(Auth::guard('employee')->user()->name),
                'approver_name'=>$approver->name,
                'to_name'=>ucfirst($approver->name),
                'id'=>$approval->id,
                'app_id'=>$approval->approval_id,
            ];
            Mail::send('approval.cc_email_noti', $details, function ($message) use ($details) {
                $message->from('sinyincinpu@gmail.com', 'Cloudark');
                $message->to($details['email']);
                $message->subject($details['subject']);
            });
        }
        $secondary_approver=Employee::where('id',$request->$request->secondary_id)->first();
        if($approver!=null){
            $details = [
                'from'=>Auth::guard('employee')->user()->email,
                'email' => $secondary_approver->email,
                'subject' => 'Approval Request',
                'request_name' =>ucfirst(Auth::guard('employee')->user()->name),
                'approver_name'=>$secondary_approver->name,
                'to_name'=>ucfirst($secondary_approver->name),
                'id'=>$approval->id,
                'app_id'=>$approval->approval_id,
                'type'=>'First Approver'
            ];
            Mail::send('approval.cc_email_noti', $details, function ($message) use ($details) {
                $message->from('sinyincinpu@gmail.com', 'Cloudark');
                $message->to($details['email']);
                $message->subject($details['subject']);
            });
        }

        if(isset($request->cc)){
            $approval=Approvalrequest::orderBy('id', 'desc')->first();
            foreach ($request->cc as $value)
            {
                $cc=new Cc_of_approval();
                $cc->approval_id=$approval->id;
                $cc->emp_id=$value;
                $cc->save();
                $emp=Employee::where("id",$value)->first();
                $approver=Employee::where("id",$request->approve_id)->first();
                $details = [
                    'from'=>Auth::guard('employee')->user()->email,
                    'email' => $emp->email,
                    'subject' => 'Approval Request CC Send',
                    'request_name' =>ucfirst(Auth::guard('employee')->user()->name),
                    'approver_name'=>$approver->name,
                    'to_name'=>ucfirst($emp->name),
                    'id'=>$approval->id,
                    'app_id'=>$approval->approval_id,
                    'type'=>'Approver'
                ];
                Mail::send('approval.cc_email_noti', $details, function ($message) use ($details) {
                    $message->from('sinyincinpu@gmail.com', 'Cloudark');
                    $message->to($details['email']);
                    $message->subject($details['subject']);
                });
            }
        }
        return redirect(route('approvals.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function show($id)
    {
        $details_approval=Approvalrequest::with('approver','secondary_approver','request_emp','contact')->where('id',$id)->firstOrFail();
//      dd($details_approval);
        $status=$this->approval_status;
        $doc_files=json_decode($details_approval->doc_file);
        $all_cmt=approval_comment::with('cmt_user')->where('approval_id',$id)->get();;

            return view('approval.show',compact('details_approval','status','doc_files','all_cmt'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $approval=Approvalrequest::where("id",$id)->first();
      $approval->state=$request->status;
      $approval->update();
      return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $cc=Cc_of_approval::where('approval_id',$id)->get();
        foreach ($cc as $c){
            $c->delete();
        }
        $approval=Approvalrequest::where('id',$id)->first();
        $approval->delete();
        return redirect()->back();
    }
}
