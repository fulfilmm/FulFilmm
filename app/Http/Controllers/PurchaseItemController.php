<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PurchaseItemController extends Controller
{
    public function store(Request $request){

       if(!isset($request->edit)){
           $Auth = Auth::guard('employee')->user()->id;
           if (!Session::has("prdata-" . $Auth)) {
               Session::push("prdata-" . $Auth, $request->all());
           }
       }

       PurchaseItem::create($request->all());

    }
    public function update(Request $request,$id){
       $item=PurchaseItem::where('id',$id)->first();
       $item->product_id=$request->product_id;
       $item->qty=$request->qty;
       $item->price=$request->price;
       $item->total=$request->total;
       $item->unit=$request->unit;
       $item->description=$request->description;
       $item->update();

    }
    public function delete(Request $request){
        $pr=PurchaseItem::where('id',$request->item_id)->first();
        $pr->delete();
    }

}
