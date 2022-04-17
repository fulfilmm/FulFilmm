<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\product;
use App\Models\ProductStockBatch;
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
        if($request->transfer_warehouse!=null){
            $stock=Stock::where('variant_id',$request->variant_id)->where('warehouse_id',$request->transfer_warehouse)->first();
            $stock->stock_balance-=$request->qty;
            $stock->available-=$request->qty;
            $stock->update();
            $out_batch = ProductStockBatch::where('product_id', $request->variant_id)->where('warehouse_id', $request->transfer_warehouse)->get();
            $remaing = $request->qty;
            foreach ($out_batch as $batch) {
                if ($batch->qty != 0) {
                    if ($batch->qty >= $remaing) {
                        $batch->qty = $batch->qty - $remaing;
                        $remaing = 0;
                        $batch->update();
                        $last_batch = ProductStockBatch::orderBy('id', 'desc')->where('product_id', $request->variant_id)->first();

                        if ($last_batch != null) {
                            $last_batch->batch_no++;
                            $batch_no = $last_batch->batch_no;
                        } else {
                            $batch_no = "Batch-00001";
                        }
                        $data['product_id'] = $request->variant_id;
                        $data['batch_no'] = $batch_no;
                        $data['supplier_id'] = $batch->supplier_id;
                        $data['qty'] = $request->qty;
                        $data['purchase_price'] = $batch->purchase_price;
                        $data['exp_date'] = $batch->exp_date;
                        $data['warehouse_id'] = $request->warehouse_id;
                        ProductStockBatch::create($data);
                    } else {
                        $remaing = $remaing - $batch->qty;
                        $data['qty'] = $batch->qty;
                        $batch->qty = 0;
                        $batch->update();
                        $last_batch = ProductStockBatch::orderBy('id', 'desc')->where('product_id', $stock_transfer->variant_id)->first();

                        if ($last_batch != null) {
                            $last_batch->batch_no++;
                            $batch_no = $last_batch->batch_no;
                        } else {
                            $batch_no = "Batch-00001";
                        }
                        $data['qty'] = $batch->qty;
                        $data['product_id'] = $stock_transfer->variant_id;
                        $data['batch_no'] = $batch_no;
                        $data['supplier_id'] = $batch->supplier_id;
                        $data['purchase_price'] = $batch->purchase_price;
                        $data['exp_date'] = $batch->exp_date;
                        $data['warehouse_id'] = $stock_transfer->to_warehouse;
                        ProductStockBatch::create($data);

                    }
                }
            }
        }
        $stockreturn=StockReturn::create($data);
        $stock=Stock::where('variant_id',$request->variant_id)->first();
        $unit=SellingUnit::where('product_id',$request->variant_id)->first();
        $stock->stock_balance=$stock->stock_balance + ($request->qty*$unit->unit_convert_rate);
        $stock->available=$stock->available + ($request->qty*$unit->unit_convert_rate);
        $stock->update();
        $product=ProductStockBatch::all();
        $total=0;
        foreach ($product as $item){
            $valuation=$item->qty*$item->purchase_price??0;
            $total+=$valuation;
        }
        $stock_transaction = new StockTransaction();
     try{
         $stock_transaction->product_name = $request->mainproduct;
         $stock_transaction->return_id = $stockreturn->id;
         $stock_transaction->warehouse_id = $request->warehouse_id;
         $stock_transaction->variant_id=$request->variant_id;
         $stock_transaction->contact_id=$request->customer_id;
         $stock_transaction->type ="Stock Return";
         $stock_transaction->emp_id=$request->emp_id;
         $stock_transaction->qty=$request->qty*$unit->unit_convert_rate;
         $stock_transaction->creator_id=Auth::guard('employee')->user()->id;
         $stock_transaction->balance=$stock->stock_balance + ($request->qty*$unit->unit_convert_rate);
         $stock_transaction->inventory_value=$total;
         $stock_transaction->save();
     }catch (\Exception $e){
         return redirect('stockreturn')->with('success',$e->getMessage());
     }
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
