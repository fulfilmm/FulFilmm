<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\product;
use App\Models\ticketrequest;
use Illuminate\Http\Request;

class ComplainTicket extends Controller
{
    public function index()
    {
        $all_request=ticketrequest::with('complain_company','compalin_product')->get();
//        dd($all_request);
        return response()->json(['all_request'=>$all_request]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products=product::all()->pluck('name','id')->all();
        $customercompany=Company::all()->pluck('name','id')->all();
        return response()->json(['products'=>$products,'customercompany'=>$customercompany]);

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
            'files.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'attach_file' => 'mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
            'description'=>'required',
            'product_id' =>'required',
            'phone'=>'required',
            'email'=>'required',
            'name'=>'required'
        ]);

        $request_ticket=new ticketrequest();
        $request_ticket->name=$request->name;
        $request_ticket->email=$request->email;
        $request_ticket->phone=$request->phone;
        $request_ticket->description=$request->description;
        $request_ticket->product_id=$request->product_id;
        $request_ticket->company_id=$request->company_id;
        $request_ticket->address=$request->address;
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $image) {
                $name = $image->getClientOriginalName();
                $image->move(public_path() . '/ticket_picture/', $name,);
                $data[] = $name;
            }
            $request_ticket->image = json_encode($data);
        }

        if ($request->hasfile('attach_file')) {
            $attach = $request->file('attach_file');
            $attach_name = $attach->getClientOriginalName();
            $attach->move(public_path() . '/ticket_attach/', $attach_name);
            $request_ticket->attach_file = $attach_name;
        }
        $request_ticket->save();
        return redirect()->back()->with('Complain Posted successful!Thank You.');
    }
}
