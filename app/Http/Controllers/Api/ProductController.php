<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EcommerceProduct;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\Warehouse;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    public function index()
    {
        $ecommerce_stocks = EcommerceProduct::with('variant')->get();
        $auth = Auth::guard('api')->user();
        return response()->json(['product' => $auth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = products_tax::all();
        $lasttax = products_tax::orderBy('id', 'desc')->first();
        $allcat = products_category::all();
        $lastcat = products_category::orderBy('id', 'desc')->first();
        return view("product.create", compact("taxes", "lasttax", "allcat", "lastcat"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new product();
        $product->name = $request->name;
        $product->tax = $request->tax;
        $product->currency_unit = $request->unit;
        $product->description = $request->description;
        $product->sale_price = $request->sale_price;
        $product->purchase_price = $request->purchase_price;
        $product->cat_id = $request->cat_id;
        $product->model_no = $request->model_no;
        $product->serial_no = $request->serial_no;
        $product->sku = $request->sku;
        $product->part_no = $request->part_no;
        $product->available_stock = $request->aval_stock;
        if (isset($request->enable)) {
            $product->enable = 1;
        } else {
            $product->enable = 0;
        }
        $image = $request->picture;
        if ($image != null) {
            $name = $image->getClientOriginalName();
            $request->picture->move(public_path() . '/product_picture/', $name);
            $product->image = $name;
        }
        $product->save();
        return redirect("/products")->with("message", "Product Create Success");

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = product::with("taxes", "category")->where("id", $id)->first();
        return view("product.show", compact("product"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $taxes = products_tax::all();
        $allcat = products_category::all();
        $product = product::with("category", "taxes")->where("id", $id)->first();
        return view("product.edit", compact("taxes", "product", "allcat"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = product::where("id", $id)->first();
        $product->name = $request->name;
        $product->tax = $request->tax;
        $product->description = $request->description;
        $product->sale_price = $request->sale_price;
        $product->purchase_price = $request->purchase_price;
        $product->cat_id = $request->cat_id;
        $product->currency_unit = $request->unit;
        if (isset($request->enable)) {
            $product->enable = 1;
        } else {
            $product->enable = 0;
        }
        $image = $request->picture;
        if ($image != null) {
            $name = $image->getClientOriginalName();
            $request->picture->move(public_path() . '/product_picture/', $name);
            $product->image = $name;
        }
        $product->update();
        return redirect("/products")->with("message", "Product Updated Success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::where("id", $id)->first();
        $product->delete();
        return redirect()->back()->with("delete", "Delete $product->name successful");
    }

    public function tax(Request $request)
    {
        $tax = new products_tax();
        $tax->name = $request->name;
        $tax->rate = $request->p_rate;
        $tax->save();
        return response()->json([
            'tax' => "success",
        ]);
    }

    public function duplicate($id)
    {
        $product = product::where("id", $id)->first();
        $duplicate_product = $product->replicate();
        $duplicate_product->save();
        return redirect("/products")->with("message", "Product Create Success");
    }

    public function action_confirm(Request $request)
    {
//        dd($request->all());
        if ($request->action_Type == "Enable") {
            foreach ($request->product_id as $product) {
                if ($product != "on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->enable = 1;
                    $action_product->update();
                }
            }

        } elseif ($request->action_Type = "Disable") {
            foreach ($request->product_id as $product) {
                if ($product != "on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->enable = 0;
                    $action_product->update();
                }
            }

        } elseif ($request->action_Type == "Delete") {
            foreach ($request->product_id as $product) {
                if ($product != "on") {
                    $action_product = product::where("id", $product)->first();
                    $action_product->delete();
                }
            }
        } elseif ($request->action_Type = "Export") {

        }
    }

    public function category()
    {
        $cats = products_category::with('product')->get();
        foreach ($cats as $cat) {
            $items = [];
            foreach ($cat->product as $p) {
                $item = ProductVariations::where('product_id', $p->id)->get();
                foreach ($item as $it) {
                    array_push($items, $it);
                }
            }
            $cat['items'] = $items;
        }
        return response()->json(['con' => true, 'result' => $cats]);
    }

    public function product_category($id,$sales_type)
    {
        $auth = Auth::guard('api')->user();
        if (Auth::guard('api')->user()->mobile_seller == 1) {
            $warehouse = Warehouse::where('warehouse_id', $auth->warehouse_id)
                ->where('mobile_warehouse', 1)
                ->get();
        } else {
            $warehouse = Warehouse::where('branch_id', $auth->office_branch_id)
                ->where('mobile_warehouse', 0)
                ->get();
        }

        $aval_product = [];
        $in_stock = [];
        foreach ($warehouse as $wh) {
            $stock = Stock::with( 'unit')->where('available', '>', 0)
                ->where('warehouse_id', $wh->id)
                ->get();
            if (!$stock->isEmpty()) {
                array_push($in_stock, $stock);
            }

        }

        foreach ($in_stock as $st) {
            foreach ($st as $inhand) {
//               return response()->json(['data'=>$inhand->id]);
                $variant = ProductVariations::with('product')->where('id', $inhand->variant_id)->first();
//                $sell_unit=SellingUnit::where('product_id',$variant->product->id)->where('unit_convert_rate',1)->first();
                $unit_price=product_price::with('unit')->where('product_id',$inhand->variant_id)
//                    ->where('unit_id',$inhand->unit[0]->id)
                        ->where('sale_type',$sales_type." Sale")
                    ->where('region_id',Auth::guard('api')->user()->region_id)
                    ->get();
                $inhand['cat_id'] = $variant->product->cat_id;
                $inhand['name']=$variant->product->name;
                $inhand['variant_name']=$variant->variant;
                $inhand['item_code']=$variant->item_code;
                $inhand['image']=$variant->image??"sesm7sXhUD1662004688.png";
                foreach ($unit_price as $u_price){
                    if($u_price->unit->unit_convert_rate==1){
                        $inhand['price']=$u_price->price;
                    }
                    for ($i=0;$i<count($inhand->unit);$i++){
                        if($inhand->unit[$i]->id==$u_price->unit_id) {
                            $inhand->unit[$i]['price'] = $u_price->price??0;
                        }
                    }
                }
                $inhand['description']=$variant->product->description??"N/A";
                if ($inhand->variant->enable == 1 && $inhand->cat_id == $id) {
                    if (count($aval_product) == 0) {
                        array_push($aval_product, $inhand);
                    } else {
                        foreach ($aval_product as $avl) {
                            if ($avl->variant_id == $variant->id) {
                                $avl['stock_balance'] = $avl->stock_balance + $inhand->stock_balance;
                                $avl['available'] = $avl->available + $inhand->available;
                                break;
                            }else{
                            array_push($aval_product, $inhand);
                            break;
                            }
                        }



                    }
                }
            }
        }
        return response()->json(['result' => $aval_product, 'con' => true]);
    }
    public function allProduct($sale_type)
    {
        $auth = Auth::guard('api')->user();
        if (Auth::guard('api')->user()->mobile_seller == 1) {
            $warehouse = Warehouse::where('warehouse_id', $auth->warehouse_id)
                ->where('mobile_warehouse', 1)
                ->get();
        } else {
            $warehouse = Warehouse::where('branch_id', $auth->office_branch_id)
                ->where('mobile_warehouse', 0)
                ->get();
        }

        $aval_product = [];
        $in_stock = [];
        foreach ($warehouse as $wh) {
            $stock = Stock::with( 'unit')->where('available', '>', 0)
                ->where('warehouse_id', $wh->id)
                ->get();
            if (!$stock->isEmpty()) {
                array_push($in_stock, $stock);
            }

        }

        foreach ($in_stock as $st) {
            foreach ($st as $inhand) {
//               return response()->json(['data'=>$inhand->id]);
                $variant = ProductVariations::with('product')->where('id', $inhand->variant_id)->first();
//                $sell_unit=SellingUnit::where('product_id',$variant->product->id)->where('unit_convert_rate',1)->first();
                $unit_price=product_price::where('product_id',$variant->id)
//                    ->where('unit_id',$inhand->unit[0]->id)
                    ->where('region_id',Auth::guard('api')->user()->region_id)
                    ->where('sale_type',$sale_type." Sale")
                    ->get();
                $prices=[];
                foreach ($unit_price as $price){
                   if($price->start_date!=null){
                       if(Carbon::parse($price->start_date)>=Carbon::today()&& Carbon::parse($price->end_date)<=Carbon::today()){
                            array_push($prices,$price);
                       }
                   }else{
                       array_push($prices,$price);
                   }
                }
                $inhand['cat_id'] = $variant->product->cat_id;
                $inhand['name']=$variant->product->name;
                $inhand['variant_name']=$variant->variant;
                $inhand['item_code']=$variant->item_code;
                $inhand['image']=$variant->image??"sesm7sXhUD1662004688.png";
                $inhand['prices']=$prices;

//                foreach ($unit_price as $u_price){
//                    if($u_price->product_id==$variant->id){
//                        if($u_price->unit_id==$inhand->unit[0]->id){
//                            $inhand['price']=$u_price->price;
//                        }
//                        for ($i=0;$i<count($inhand->unit);$i++){
//
//                            if($inhand->unit[$i]->id==$u_price->unit_id) {
//                                $inhand->unit[$i]['price'] = $u_price->price??0;
//                            }
//
//                        }
//                    }
//
//                }
                $inhand['description']=$variant->product->description??"N/A";
                if ($inhand->variant->enable == 1 ) {
                    if (count($aval_product) == 0) {
                        array_push($aval_product, $inhand);
                    } else {
                        foreach ($aval_product as $avl) {
                            if ($avl->variant_id == $variant->id) {
                                $avl['stock_balance'] = $avl->stock_balance + $inhand->stock_balance;
                                $avl['available'] = $avl->available + $inhand->available;
                                break;
                            }else{
                                array_push($aval_product, $inhand);
                                break;
                            }
                        }



                    }
                }
            }
        }
        return response()->json(['result' => $aval_product, 'con' => true]);
    }


}
