<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Approvalrequest;
use App\Models\Cc_of_approval;
use App\Models\Employee;
use App\Models\RequestItem;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApprovalController extends Controller
{
    use NotifyTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth=Auth::guard('api')->user();
        if($auth->role->name=='CEO'||$auth->role->name=='Super Admin'){
            $approvals=Approvalrequest::with('approver','secondary_approver','request_emp','contact','item')->get();

        }else{
            $approvals=Approvalrequest::with('approver','secondary_approver','request_emp','contact','item')->where('emp_id',$auth->id)->get();
        }

       return response()->json(['con'=>true,'result'=>$approvals]);
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
        $approval->state='New';
        $approval->amount=$request->type=='Procurement'?$request->procurement_amount:($request->type=='Business Trip'?$request->budget:($request->type=='Payment'?$request->payment_amount:null));
        $approval->location=$request->location??'';
        $approval->contact_id=$request->type=='Payment'?$request->contact:$request->supplier;
        $approval->quantity=$request->quantity??'';
        $approval->warehouse_id=$request->warehouse_id;
        if($request->members!=null){
            $trip_member=json_encode($request->members);
        }
        $approval->trip_members=$trip_member??null;
        $approval->emp_id=Auth::guard('api')->user()->id;
        if($request->hasfile('doc_file')) {
            foreach ($request->file('doc_file') as $doc_file) {
                $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$doc_file->extension();
                $doc_file->move(public_path() . '/approval_doc/', $input['filename']);
                $data[] = $input['filename'];
            }

            $approval->doc_file=json_encode($data);
        }
        if(isset($request->secondary_id)){
            $approval->secondary_approved=$request->secondary_id;
        }
        $approval->save();
        if($request->type=='Items Request'||$request->type=='Payment'||$request->type=='Procurement'){
            for($i=0;$i<count($request->product);$i++){
                $item=new RequestItem();
                $item->product_name=$request->product[$i];
                $item->variant=$request->variant[$i];
                $item->amount=$request->amount[$i];
                $item->qty=$request->qty[$i];
                $item->approval_id=$approval->id;
                $item->save();
            }

        }



        $approver=Employee::where('id',$request->approve_id)->first();
        $secondary_approver=Employee::where('id',$request->secondary_id)->first();
        $cc_mail=[];
        if($secondary_approver!=null){
            array_push($cc_mail,$secondary_approver->email);
            $this->addnotify($request->secondary_id,'success','Add new approval '.$approval->approval_id.'.','approvals/'.$approval->id,Auth::guard('api')->user()->id);
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
                array_push($cc_mail,$emp->email);
                $approver=Employee::where("id",$request->approve_id)->first();
                $this->addnotify($value,'success','Add new approval '.$approval->approval_id.'.','approvals/'.$approval->id,Auth::guard('api')->user()->id);
            }
        }

        if($approver!=null){
            $details = [
                'from'=>Auth::guard('api')->user()->email,
                'email' => $approver->email,
                'subject' => 'Approval Request',
                'request_name' =>ucfirst(Auth::guard('api')->user()->name),
                'approver_name'=>$approver->name,
                'to_name'=>ucfirst($approver->name),
                'id'=>$approval->id,
                'cc'=>$cc_mail,
                'app_id'=>$approval->approval_id,
            ];
            Mail::send('approval.cc_email_noti', $details, function ($message) use ($details) {
                $message->from('sinyincinpu@gmail.com', 'Cloudark');
                $message->to($details['email']);
                $message->cc($details['cc']);
                $message->subject($details['subject']);
            });
            $this->addnotify($request->approve_id,'success','Add new approval '.$approval->approval_id.'.','approvals/'.$approval->id,Auth::guard('api')->user()->id);
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
