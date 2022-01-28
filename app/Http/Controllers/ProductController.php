<?php

namespace App\Http\Controllers;

use App\Jobs\ProductJob;
use App\Models\Customer;
use App\Models\Freeofchare;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use function Livewire\str;
use Livewire\WithPagination;
use Psy\Util\Str;

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
//        dd($suppliers);
        return view("product.create",compact("taxes","category",'warehouses','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
//
        $product=new product();
        $product->name=$request->name;
        $product->description=$request->detail;
        $product->model_no=$request->model_no;
        $product->cat_id=$request->mian_cat;
        $product->sub_cat_id=$request->sub_cat;
        $product->brand_id=$request->brand_id;
        if (isset($request->picture)) {
//            if ($request->picture != null) {
            foreach ($request->file('picture') as $image) {
                $input['imagename'] =\Illuminate\Support\Str::random(10).time().'.'.$image->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($image->path());
                $img->resize(400, 800, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);
                $data[] = $input['imagename'];

            }
            $product->image=json_encode($data);
        }


        $product->save();
        return redirect("/products")->with("message","Product Create Success");

    }
    public function create_variant(){
        $product=product::all()->pluck('name','id')->all();
        return view('product.variantadd',compact('product'));
    }
    public function variant_add(Request $request){
        $this->validate($request,[
            'product_code'=>'required',
            'variant'=>'required',
            'picture.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product=product::where('id',$request->product_id)->first();
        $variation=new ProductVariations();
        if (isset($request->picture)) {
//            if ($request->picture != null) {
                foreach ($request->file('picture') as $image) {
                $input['imagename'] =\Illuminate\Support\Str::random(16).'.'.$image->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($image->path());
                $img->save($filePath.'/'.$input['imagename']);
                $data[] = $input['imagename'];

            }
            $variation->image =json_encode($data);
        }
        $variation->product_name=$product->name;
        $variation->product_id=$request->product_id;
        $variation->description=$request->description;
        $variation->product_code=$request->product_code;
        $variation->serial_no=$request->serial_no;
        $variation->variant=$request->variant;
        $variation->exp_date=Carbon::create($request->exp_date);
        $variation->save();
        return redirect(route('products.show',$request->product_id));
    }
    public function show_variant($id){
        $product=ProductVariations::with('product')->where('id',$id)->firstOrFail();
        $stock=Stock::with('warehouse')->where('variant_id',$id)->get();
        $selling_info=product_price::with('unit')->where('product_id',$id)->get();
        return view('product.variantshow',compact('product','stock','selling_info'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=product::with("category",'sub_cat')->where("id",$id)->firstOrFail();
        $variantions=ProductVariations::where('product_id',$product->id)->get();
//        dd($variantions);
        return view("product.show",compact("product",'variantions'));
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
        $product->description=$request->detail;
        $product->model_no=$request->model_no;
        $product->cat_id=$request->mian_cat;
        $product->sub_cat_id=$request->sub_cat;
        $product->brand_id=$request->brand_id;
        if (isset($request->picture)) {
//            if ($request->picture != null) {
            foreach ($request->file('picture') as $image) {
                $input['imagename'] =\Illuminate\Support\Str::random(10).time().'.'.$image->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($image->path());
                $img->resize(400, 800, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);
                $data[] = $input['imagename'];

            }
            $product->image=json_encode($data);
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
    public function focproduct(){
        $foc=Freeofchare::with('emp','variant')->get();
        return view('product.foc',compact('foc'));
    }
}
