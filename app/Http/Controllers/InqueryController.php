<?php

namespace App\Http\Controllers;

use App\Models\Inquery;
use App\Models\product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Version;

class InqueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inqueries=Inquery::all();
        $products=product::all();
        $townships=$this->townships;
        return view('inquery.index',compact('inqueries','products','townships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $townships=['Botataung Township','Dagon Seikkan Township','East Dagon Township','North Dagon Township',
        'North Okkalapa Township','Pazundaung Township','South Dagon Township','South Okkalapa Township',
        'Thingangyun Township','Dawbon Township','Mingala Taungnyunt Township','Tamwe Township','Thaketa Township',
        'Yankin Township','Hlaingthaya Township','Insein Township','Mingaladon Township', 'Shwepyitha Township',
        'Hlegu Township','Hmawbi Township','Htantabin Township', 'Taikkyi Township','Dala Township','Seikkyi Kanaungto Township',
        'Cocokyun Township', 'Kawhmu Township','Kayan Township','Kungyangon Township','Kyauktan Township','Thanlyin Township',
        'Thongwa Township','Twante Township','Ahlon Township','Bahan Township','Dagon Township','Kyauktada Township',
        'Kyimyindaing Township','Lanmadaw Township','Latha Township','Pabedan Township','Sanchaung Township','Seikkan Township',
        'Hlaing Township','Kamayut Township','Mayangon Township'];
    public function create(Request $request)
    {
        $products=product::all();
        $townships=$this->townships;
        return view('inquery.create',compact('products','townships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $inquery=new Inquery();
        $inquery->subject=$request->subject;
        $inquery->customer_name=$request->client_name;
        $inquery->phone=$request->client_phone;
        $inquery->email=$request->email;
        $inquery->description=$request->description;
        $inquery->product=json_encode($request->product_id);
        $inquery->township=$request->township;
        $inquery->age=$request->age;
        $inquery->convert_lead=$request->convert;
        $inquery->save();
        return redirect()->route('inqueries.index')->with('success', __('alerts.update_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $in_query=Inquery::where("id",$id)->first();
        $products=product::all();
        return view('inquery.show',compact('in_query','products'));
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
        $inquery=Inquery::where('id',$id)->first();
        $inquery->subject=$request->subject;
        $inquery->customer_name=$request->client_name;
        $inquery->phone=$request->client_phone;
        $inquery->email=$request->email;
        $inquery->description=$request->description;
        $inquery->product=json_encode($request->product_id);
        $inquery->township=$request->township;
        $inquery->age=$request->age;
        $inquery->update();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inquery=Inquery::where('id',$id)->fist();
        $inquery->delete();
        return redirect()->back();
    }
    public function convert_lead($id){
        $inquery=Inquery::where("id",$id)->first();
        $inquery->convert_lead=true;
        $inquery->update();
        return redirect(route('leads.create',compact('inquery')));
    }
}
