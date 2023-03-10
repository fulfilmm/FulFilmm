<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcommerceProduct;
use App\Models\product;
use App\Models\products_category;
use App\Models\products_tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $ecommerce_stocks=EcommerceProduct::with('variant')->get();
        $auth=Auth::guard('api')->user();
        return response()->json(['product'=>$auth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes=products_tax::all();
        $lasttax=products_tax::orderBy('id', 'desc')->first();
        $allcat=products_category::all();
        $lastcat=products_category::orderBy('id', 'desc')->first();
        return view("product.create",compact("taxes","lasttax","allcat","lastcat"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product=new product();
        $product->name=$request->name;
        $product->tax=$request->tax;
        $product->currency_unit=$request->unit;
        $product->description=$request->description;
        $product->sale_price=$request->sale_price;
        $product->purchase_price=$request->purchase_price;
        $product->cat_id=$request->cat_id;
        $product->model_no=$request->model_no;
        $product->serial_no=$request->serial_no;
        $product->sku=$request->sku;
        $product->part_no=$request->part_no;
        $product->available_stock=$request->aval_stock;
        if(isset($request->enable))
        {
            $product->enable=1;
        }else{
            $product->enable=0;
        }
        $image = $request->picture;
        if($image!=null) {
            $name = $image->getClientOriginalName();
            $request->picture->move(public_path() . '/product_picture/', $name);
            $product->image = $name;
        }
        $product->save();
        return redirect("/products")->with("message","Product Create Success");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=product::with("taxes","category")->where("id",$id)->first();
        return view("product.show",compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taxes=products_tax::all();
        $allcat=products_category::all();
        $product=product::with("category","taxes")->where("id",$id)->first();
        return view("product.edit",compact("taxes","product","allcat"));
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
        $product=product::where("id",$id)->first();
        $product->name=$request->name;
        $product->tax=$request->tax;
        $product->description=$request->description;
        $product->sale_price=$request->sale_price;
        $product->purchase_price=$request->purchase_price;
        $product->cat_id=$request->cat_id;
        $product->currency_unit=$request->unit;
        if(isset($request->enable))
        {
            $product->enable=1;
        }else{
            $product->enable=0;
        }
        $image = $request->picture;
        if($image!=null) {
            $name = $image->getClientOriginalName();
            $request->picture->move(public_path() . '/product_picture/', $name);
            $product->image = $name;
        }
        $product->update();
        return redirect("/products")->with("message","Product Updated Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=product::where("id",$id)->first();
        $product->delete();
        return redirect()->back()->with("delete","Delete $product->name successful");
    }
    public function tax(Request $request){
        $tax=new products_tax();
        $tax->name=$request->name;
        $tax->rate=$request->p_rate;
        $tax->save();
        return response()->json([
            'tax' => "success",
        ]);
    }
    public function category(Request $request){
        $cat=new products_category();
        $cat->name=$request->name;
        $cat->save();
        return response()->json([
            'tax' => "success",
        ]);
    }
    public function duplicate($id){
        $product=product::where("id",$id)->first();
        $duplicate_product=$product->replicate();
        $duplicate_product->save();
        return redirect("/products")->with("message","Product Create Success");
    }
    public function action_confirm(Request $request){
//        dd($request->all());
        if($request->action_Type=="Enable"){
            foreach ($request->product_id as $product){
                if($product!="on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->enable = 1;
                    $action_product->update();
                }
            }

        }elseif ($request->action_Type="Disable"){
            foreach ($request->product_id as $product){
                if($product!="on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->enable = 0;
                    $action_product->update();
                }
            }

        }elseif ($request->action_Type=="Delete"){
            foreach ($request->product_id as $product){
                if($product!="on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->delete();
                }
            }
        }elseif ($request->action_Type="Export"){

        }
    }
}
