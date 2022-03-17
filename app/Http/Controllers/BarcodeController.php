<?php

namespace App\Http\Controllers;

use App\Models\product_price;
use App\Models\ProductVariations;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function barcodecreate(){
        $products=ProductVariations::all();
        $type=['C39','C39+','C39E','C39E+','C93','S25','S25+','I25','I25+','C128','C128A','C128B','EAN2','EAN5',
        'EAN13','UPCA','UPCE','MSI','MSI+','POSTNET','PLANET','RMS4CC','KIX','CODABAR','CODE11','PHARMA','PHARMA2T'];
        return view('product.barcodecreate',compact('products','type'));
    }
    public function barcode(Request $request){
        $product=ProductVariations::where('id',$request->product_name)->first();
        $type=$request->btype??'C128';
        $product_price=product_price::where('product_id',$request->product_name)->where('multi_price',0)->where('active',1)->first();
       if($product_price==null){
           return redirect()->back()->with('error','Firstly,Fix Product Selling Price');
       }else {
           return view('product.barcodegenerate', compact('product_price', 'product','type'));
       }
    }
    //
}
