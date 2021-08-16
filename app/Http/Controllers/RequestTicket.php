<?php

namespace App\Http\Controllers;

use App\Models\case_type;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Group;
use App\Models\MainCompany;
use App\Models\priority;
use App\Models\product;
use App\Models\ticket;
use App\Models\ticketrequest;
use Illuminate\Http\Request;

class RequestTicket extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_request=ticketrequest::with('complain_company','compalin_product')->get();
        return view("ticket.complain_request",compact('all_request'));
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
        return view('ticket.ticket_for_guest', compact('products','customercompany'));

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
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complain=ticketrequest::with('complain_company','compalin_product')->where('id',$id)->first();
        $photos = json_decode($complain->image);
        return view('ticket.requestshow',compact('complain','photos'));
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
    public function data_all()
    {
        $depts = Department::all();
        $cases = case_type::all();
        $priorities = priority::all();
        $products = product::all();
        $clients = Customer::all();
        $all_emp = Employee::all();
        return ['depts' => $depts, 'case' => $cases, 'priority' => $priorities, 'product' => $products, 'client' => $clients, 'all_emp' => $all_emp];
    }
    public function openTicket($id){
        $parent_companies = Company::all()->pluck('name', 'id')->all();
        $companies = Company::all()->pluck('name', 'id')->all();
        $data = $this->data_all();
        $prefix = MainCompany::where('ismaincompany', true)->pluck('ticket_prefix', 'id')->first();
        $last_ticket = ticket::orderBy('id', 'desc')->first();
        if (isset($last_ticket)) {
            // Sum 1 + last id
            $last_ticket->ticket_id++;
            $ticket_id = $last_ticket->ticket_id;
        } else {
            $ticket_id = ($prefix ?: 'Ticket') . "-00001";
        }
        $group = Group::all()->pluck('name', 'id')->all();
        $complain=ticketrequest::with('complain_company','compalin_product')->where('id',$id)->first();
        return view('ticket.create', compact('ticket_id', 'data', 'companies', 'parent_companies', 'group','complain'));


    }
}
