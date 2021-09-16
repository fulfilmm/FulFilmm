<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Emailsetting;
use App\Models\MainCompany;
use Illuminate\Http\Request;


class CompanySetting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */


    public function company()
    {
        $company=MainCompany::where('ismaincompany',true)->first();
        return $company;
    }

//    public function index()
//    {
//        //
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $company=$this->company();

        return view('settings.companysettings',compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           'name'=>'required'
        ]);
        $isexit=MainCompany::where('ismaincompany',true)->first();
        $maincompany=$isexit==null?new MainCompany():$isexit;
        $maincompany->name=$request->name;
        $maincompany->contact_person=$request->contact_person;
        $maincompany->address=$request->address;
        $maincompany->country=$request->country;
        $maincompany->city=$request->city;
        $maincompany->state=$request->state;
        $maincompany->postcode=$request->post_code;
        $maincompany->email=$request->email;
        $maincompany->phone=$request->phone;
        $maincompany->mobile_phone=$request->mobile;
        $maincompany->fax=$request->fax;
        $maincompany->web_link=$request->web_link;
        if($request->logo!=null) {
            $image = $request->logo;
            $name = $image->getClientOriginalName();
            $request->logo->move(public_path() . '/img/profiles', $name);
            $maincompany->logo = $name;
        }
        $isexit==null?$maincompany->save():$maincompany->update();
        return redirect('/')->with('success','Company Setting up successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $company=$this->company();
        return view('settings.prefix_setting',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $prefix=$this->company();
        if($prefix==null){
            return redirect()->route('companysettings.create')->with('error', 'Setting up your company first!');
        }else {
            $prefix->invoice_prefix = $request->invoice_prefix;
            $prefix->ticket_prefix = $request->ticket_prefix;
            $prefix->lead_prefix = $request->lead_prefix;
            $prefix->quotation_prefix = $request->quotation_prefix;
            $prefix->update();
            return redirect('/')->with('success', 'Prefix Setting Up Successful');
        }
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
    public function emailSetting(){
        $mail=Emailsetting::where('isactive',true)->first();
        return view('settings.email-settings',compact('mail'));
    }
    public function mailsetting(Request $request){
       $mail=new Emailsetting();
       $mail->create($request->all());
       return redirect()->route('emailsetting')->with('success','Email Setting up successful!');
    }
}
