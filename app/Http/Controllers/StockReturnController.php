<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\product;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockReturn;
use App\Models\StockTransaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stockreturn=StockReturn::with('invoice','employee','variant','unit','warehouse','creator')->get();
        return view('stock.StockReturn.index',compact('stockreturn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units=SellingUnit::all();
        $products=product::all();
        $variants=ProductVariations::all();
        $warehouse=Warehouse::all();
        $invoices=Invoice::all();
        $employees=Employee::all();
        $customers=Customer::all();
        return view('stock.StockReturn.create',compact('units','products','warehouse','invoices','employees','customers','variants'));
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
            'variant_id'=>'required',
            'sell_unit'=>'required',
            'warehouse_id'=>'required',
            'qty'=>'required'
        ]);
        $data=$request->all();
        if ($request->hasfile('attachment')) {
            $attach = $request->file('attachment');
            $input['filename'] =\Illuminate\Support\Str::random(10).time().'.'.$attach->extension();
            $attach->move(public_path() . '/ticket_attach/', $input['filename']);
            $data['attachment']=$input['filename'];
        }
        $data['creator_id']=Auth::guard('employee')->user()->id;
        $stockreturn=StockReturn::create($data);
        $stock=Stock::where('variant_id',$request->variant_id)->first();
        $unit=SellingUnit::where('product_id',$request->variant_id)->first();
        $stock_transaction = new StockTransaction();
     try{
         $stock_transaction->product_name = $request->mainproduct;
         $stock_transaction->return_id = $stockreturn->id;
         $stock_transaction->warehouse_id = $request->warehouse_id;
         $stock_transaction->variant_id=$request->variant_id;
         $stock_transaction->contact_id=$request->customer_id;
         $stock_transaction->type ="Stock Return";
         $stock_transaction->emp_id=$request->emp_id;
         $stock_transaction->creator_id=Auth::guard('employee')->user()->id;
         $stock_transaction->balance=$stock->stock_balance + ($request->qty*$unit->unit_convert_rate);
         $stock_transaction->save();
     }catch (\Exception $e){
         return redirect('stockreturn')->with('success',$e->getMessage());
     }
        $stock->stock_balance=$stock->stock_balance + ($request->qty*$unit->unit_convert_rate);
        $stock->available=$stock->available + ($request->qty*$unit->unit_convert_rate);
        $stock->update();
        return redirect('stockreturn')->with('success','Stock Return Created');

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
