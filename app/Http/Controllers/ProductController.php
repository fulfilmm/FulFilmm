<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Models\product;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\SkuValue;
use App\Models\Stock;
use App\Models\VariantKey;
use App\Models\VariantValue;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Livewire\WithPagination;

class ProductController extends Controller
{
    use StockTrait;
    use WithPagination;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=product::with('taxes','category','sub_cat')->paginate(10);

        return view("product.index",compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes=products_tax::all();
        $category=products_category::all();
        $warehouses=Warehouse::all();
        $suppliers=Customer::where('customer_type','Supplier')->get();
        $v_type=VariantKey::all();

        return view("product.create",compact("taxes","category",'warehouses','suppliers','v_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $a = array('Red', 'Green', 'yellow','Black');
//        $b = array('Small', 'Large');
//        $merged = array_merge($a, $b);
//        $test=shuffle($merged);
//        dd($merged);
//        $variant=VariantKey::all()->pluck('name','id')->all();
//dd(random_int(8,8));
        $product=new product();
        $product->name=$request->name;
        $product->tax=$request->tax;
        $product->product_code=$request->main_product_code;
        $product->currency_unit=$request->unit;
        $product->description=$request->detail;
        $product->cat_id=$request->mian_cat;
        $product->model_no=$request->model_no;
        $product->serial_no=$request->serial_no;
        $product->sku=$request->sku;
        $product->sub_cat_id=$request->sub_cat;
        $product->part_no=$request->part_no;
        $product->unit=$request->unit;
        $product->stock_type=$request->stock_type;
        if(isset($request->enable))
        {
            $product->enable=1;
        }else{
            $product->enable=0;
        }
        $product->save();
        $sku_couter=0;
       if($request->type!=null){
           foreach ($request->type as $item=>$v){
               $name="value".$v;
//dd($request->$name);
               if(isset($request->$name)){
                   $sku_couter=$sku_couter==0?count($request->$name):$sku_couter*count($request->$name);
                   foreach ($request->$name as $key=>$value){
//                    dd($value);
                       $attribute_value=new VariantValue();
                       $attribute_value->product_id=$product->id;
                       $attribute_value->variant_key=$v;
                       $attribute_value->value=$value;
                       $attribute_value->save();
                   }
               }


           }
           for ($i=0;$i<$sku_couter;$i++){
               $sku=new Stock();
               $sku->product_id=$product->id;
               $sku->sku=str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
               $sku->save();
           }
       }
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
        $product=product::with("taxes","category")->where("id",$id)->firstOrFail();
        $sku_value=SkuValue::with('variant','variant_value')->where('product_id',$id)->get();
        $sku=Stock::where('product_id',$id)->get();
//        dd($variantions);
        return view("product.show",compact("product",'sku_value','sku'));
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
        $category=products_category::all();
        $warehouses=Warehouse::all();
        $suppliers=Customer::where('customer_type','Supplier')->get();
        $product=product::with("category","taxes")->where("id",$id)->firstOrFail();
        $product_variant=ProductVariations::where('product_id',$id)->get();
        $stock_variant=[];
        foreach ($product_variant as $variant){
//            dd($variant->id);
            $stock=Stock::where('variant_id',$variant->id)->first();
           if($stock){
              array_push($stock_variant,$stock);
           }
        }
//dd($stock_variant);
        return view("product.edit",compact('stock_variant',"taxes","product","category",'warehouses','suppliers','product_variant'));
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
//        dd($request->all());
        $product=product::where("id",$id)->firstOrFail();
        $product->name=$request->name;
        $product->tax=$request->tax;
        $product->product_code=$request->main_product_code;
        $product->currency_unit=$request->unit;
        $product->description=$request->detail;
        $product->cat_id=$request->cat_id;
        $product->model_no=$request->model_no;
        $product->serial_no=$request->serial_no;
        $product->sku=$request->sku;
        $product->part_no=$request->part_no;
        $product->unit=$request->unit;
        $product->stock_type=$request->stock_type;
        if(isset($request->enable))
        {
            $product->enable=1;
        }else{
            $product->enable=0;
        }
        $product->update();
        for ($i=0;$i<count($request->field_count);$i++) {
//            dd($request->variant_id[$i]);
            $is_exit =ProductVariations::where('id', $request->variant_id[$i])->first();
//            dd($is_exit);
            if ($is_exit == null) {
                $variation = new ProductVariations();
                $image = $request->picture[$i];
                if ($image != null) {
                    $name = $image->getClientOriginalName();
                    $request->picture[$i]->move(public_path() . '/product_picture/', $name);
                    $variation->image = $name;
                }
                $variation->product_id = $product->id;
                $variation->description = $request->description[$i];
                $variation->price = $request->price[$i];
                $variation->purchase_price = $request->purchase_price[$i];
                $variation->warehouse_id = $request->warehouse_id[$i];
                $variation->product_code = $request->product_code[$i];
//           $variation->barcode=$request->barcode[$i];
                $variation->discount_rate = $request->discount_rate[$i];
                $variation->size = $request->size[$i];
                $variation->color = $request->color[$i];
                $variation->other = $request->other[$i];
                $variation->exp_date = Carbon::create($request->exp_date[$i]);
                $variation->save();
                $data=['qty'=>$request->qty[$i],'warehouse_id'=>$request->warehouse_id[$i],'supplier_id'=>$request->supplier_id,'variantion_id'=>$variation->id];
                $this->stockin($data);
            } else {
                $variation=ProductVariations::where('id', $request->variant_id[$i])->first();
//                dd($variation);
                $image = $request->picture[$i]??null;
                if ($image != null) {
                    $name = $image->getClientOriginalName();
                    $request->picture[$i]->move(public_path() . '/product_picture/', $name);
                    $variation->image = $name;
                }
                $variation->product_id = $product->id;
                $variation->description = $request->description[$i];
                $variation->price = $request->price[$i];
                $variation->purchase_price = $request->purchase_price[$i];
                $variation->warehouse_id = $request->warehouse_id[$i];
                $variation->product_code = $request->product_code[$i];
//           $variation->barcode=$request->barcode[$i];
                $variation->discount_rate = $request->discount_rate[$i];
                $variation->size = $request->size[$i];
                $variation->color = $request->color[$i];
                $variation->other = $request->other[$i];
                $variation->exp_date = Carbon::create($request->exp_date[$i]);
                $variation->update();
            }
        }
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
        $product=product::where("id",$id)->firstOrFail();
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
    public function tax_index(){
        $taxes=products_tax::all();

        return view('settings.tax',compact('taxes'));
    }
    public function tax_delete($id){
//        dd($id);
        $tax=products_tax::where('id',$id)->first();
        $tax->delete();
        return redirect()->back();
    }

    public function category(Request $request){
//        dd($request->all());
        $cat=new products_category();
        $cat->name=$request->name;
        $cat->parent_id=$request->parent_id;
        if($request->parent_id==null){
         $cat->parent=1;
        }else{
            $cat->parent=0;
        }
        $cat->save();
        return response()->json([
            'tax' => "success",
        ]);
    }
    public function category_index(){
        $category=products_category::with('main')->get();
        return view('product.category',compact('category'));
    }
    public function category_update(Request $request,$id){
//        dd($request->all());
        $cat=products_category::where('id',$id)->first();
        $cat->name=$request->cat_name;
        $cat->update();
        return redirect()->back();
    }
    public function category_delete($id){
        $cat=products_category::where('id',$id)->first();
        $cat->delete();
        return redirect()->back();
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
    public function add_variant(Request $request){
//        dd($request->all());
        $is_exists=VariantKey::where('name',$request->name)->first();
        dd($is_exists);
        if($is_exists==null){
            VariantKey::create($request->all());
        }else{
            $is_exists->active=1;
            $is_exists->update();
        }

//      if($request->key!=null&&$request->value!=null){
//        Session::push($request->key,$request->value);
//       $key=Session::get('key');
//      if(!isset($request->key,$key)){
//       $request->session()->push('key',$request->key);
//      }
//
//      }
    }
}
