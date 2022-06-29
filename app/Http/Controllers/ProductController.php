<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ItemImport;
use App\Imports\ProductCategoryImport;
use App\Imports\ProductImport;
use App\Jobs\ProductJob;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Freeofchare;
use App\Models\product;
use App\Models\product_price;
use App\Models\products_category;
use App\Models\products_tax;
use App\Models\ProductVariations;
use App\Models\SellingPriceRule;
use App\Models\SellingUnit;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\Warehouse;
use App\Traits\StockTrait;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use function Livewire\str;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Util\Str;
use Tymon\JWTAuth\Claims\Custom;

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
        $products = product::with('taxes', 'category', 'sub_cat', 'brand')->paginate(10);
        $variants = ProductVariations::with('supplier')->get();
        return view("product.index", compact("products", 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = products_tax::all();
        $category = products_category::all();
        $warehouses = Warehouse::all();
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $brand = Brand::all();
//        dd($suppliers);
        return view("product.create", compact("taxes", "category", 'warehouses', 'suppliers', 'brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
      if(isset($request->unit)){
          $this->validate($request,[
              'name'=>'required',
              'unit.*'=>'required',
              'unit_convert_rate.*'=>'required'

          ]);
      }else{
          $this->validate($request,[
              'name'=>'required',

          ]);
      }
//
        $product = new product();
        $product->name = $request->name;
        $product->description = $request->detail;
        $product->model_no = $request->model_no;
        $product->cat_id = $request->mian_cat;
        $product->sub_cat_id = $request->sub_cat;
        $product->brand_id = $request->brand_id;
        $product->product_code=$request->product_code;
        if (isset($request->picture)) {
//            if ($request->picture != null) {
            $image = $request->file('picture');
            $input['imagename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $image->extension();
            $filePath = public_path('/product_picture/');
            $img = Image::make($image->path());
            $img->resize(400, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath . '/' . $input['imagename']);
            $product->image = $input['imagename'];
        }


        $product->save();
        if(isset($request->unit)){
            for ($i=0;$i<count($request->unit);$i ++){
                $data['product_id']=$product->id;
                $data['unit']=$request->unit[$i];
                $data['unit_convert_rate']=$request->unit_convert_rate[$i];
                SellingUnit::create($data);
            }
        }
        if(isset($request->has_variant)) {

            return redirect('product/variant/create/'.$product->id)->with("message", "Product Create Success");
        }else{
           try{
               $variation=new ProductVariations();
               $variation->item_code=$request->product_code;
               $variation->image=$input['imagename']??null;
               $variation->product_name = $request->name;
               $variation->product_id = $product->id;
               $variation->save();
               SellingUnit::where('product_id',$request->product_id)->get();
           }catch (\Exception $e){
               return redirect()->back()->with('danger',$e->getMessage());
           }
            return redirect('products')->with('success','Product create Successful');
        }

    }

    public function create_variant($id)
    {
        $product = product::where('id',$id)->first();
        $supplier = Customer::where('customer_type', 'Supplier')->get();
        return view('product.variantadd', compact('product', 'supplier'));
    }

    public function variant_add(Request $request)
    {
//        dd($request->all());
//        dd(count($request->variant));
        $this->validate($request, [
            'variant' => 'required',
            'picture.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = product::where('id', $request->product_id)->first();

        for($i=0;$i<count($request->variant);$i++){
            $variation = new ProductVariations();
            if (isset($request->picture[$i])) {
//            if ($request->picture != null) {
                $image = $request->file('picture')[$i];
                $input['imagename'] = \Illuminate\Support\Str::random(16) . '.' . $image->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($image->path());
                $img->save($filePath . '/' . $input['imagename']);
                $variation->image = $input['imagename'];
            }
            $variation->product_name = $product->name;
            $variation->product_id = $request->product_id;
            $variation->variant=$request->variant[$i];
            $variation->item_code =$request->variant[$i].'-'.$product->product_code;
            $variation->additional_price=$request->additional_price[$i]??0;
            $variation->save();
            SellingUnit::where('product_id',$request->product_id)->get();
        }
        return redirect(route('products.show', $request->product_id));
    }

    public function show_variant($id)
    {
        $product = ProductVariations::with('product')->where('id', $id)->firstOrFail();
        $stock = Stock::with('warehouse')->where('variant_id', $id)->get();
        $selling_info = product_price::with('unit')->where('product_id', $id)->get();
        return view('product.variantshow', compact('product', 'stock', 'selling_info'));

    }

    public function update_variant(Request $request, $id)
    {
        $variation = ProductVariations::where('id', $id)->first();
        if (isset($request->picture)) {
//            if ($request->picture != null) {
            $image = $request->file('picture');
            $input['imagename'] = \Illuminate\Support\Str::random(16) . '.' . $image->extension();

            $filePath = public_path('/product_picture/');

            $img = Image::make($image->path());
            $img->save($filePath . '/' . $input['imagename']);
           if($request->picture!=null) {
               $variation->image = $input['imagename'];
           }
        }
        $variation->item_code = $request->item_code;
        $variation->variant = $request->variant;
        $variation->additional_price=$request->additional_price;
        $variation->pricing_type=$request->pricing_type;
        $variation->update();
        return redirect('variant/list')->with('success', 'Product Variant Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = product::with("category", 'sub_cat')->where("id", $id)->firstOrFail();
        $variantions = ProductVariations::with('supplier')->where('product_id', $product->id)->get();
        $supplier = Customer::where('customer_type', 'Supplier')->get();
//        dd($variantions);
        return view("product.show", compact("product", 'variantions', 'supplier'));
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
        $category = products_category::all();
        $warehouses = Warehouse::all();
        $suppliers = Customer::where('customer_type', 'Supplier')->get();
        $product = product::with("category", "taxes")->where("id", $id)->firstOrFail();
        $product_variant = ProductVariations::where('product_id', $id)->get();
        $brand = Brand::all();
        $stock_variant = [];
        foreach ($product_variant as $variant) {
//            dd($variant->id);
            $stock = Stock::where('variant_id', $variant->id)->first();
            if ($stock) {
                array_push($stock_variant, $stock);
            }
        }
//dd($stock_variant);
        return view("product.edit", compact('stock_variant', "taxes", "product", "category", 'warehouses', 'suppliers', 'product_variant', 'brand'));
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
//        dd($request->all());
        $product = product::where("id", $id)->firstOrFail();
        $product->name = $request->name;
        $product->description = $request->detail;
        $product->model_no = $request->model_no;
        $product->cat_id = $request->mian_cat;
        $product->sub_cat_id = $request->sub_cat;
        $product->brand_id = $request->brand_id;
        if (isset($request->picture)) {
//            if ($request->picture != null) {
                $image=$request->file('picture');
                $input['imagename'] = \Illuminate\Support\Str::random(10) . time() . '.' . $image->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($image->path());
                $img->resize(400, 800, function ($const) {
                    $const->aspectRatio();
                })->save($filePath . '/' . $input['imagename']);
            if($request->picture!=null) {
                $product->image =$input['imagename'];
            }
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
        $product = product::where("id", $id)->firstOrFail();
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

    public function tax_index()
    {
        $taxes = products_tax::all();

        return view('settings.tax', compact('taxes'));
    }

    public function tax_delete($id)
    {
//        dd($id);
        $tax = products_tax::where('id', $id)->first();
        $tax->delete();
        return redirect()->back();
    }

    public function category(Request $request)
    {
//        dd($request->all());
        $cat = new products_category();
        $cat->name = $request->name;
        $cat->parent_id = $request->parent_id;
        if ($request->parent_id == null) {
            $cat->parent = 1;
        } else {
            $cat->parent = 0;
        }
        $cat->save();
        return response()->json([
            'tax' => "success",
        ]);
    }

    public function category_index()
    {
        $category = products_category::with('main')->get();
        return view('product.category', compact('category'));
    }

    public function category_update(Request $request, $id)
    {
//        dd($request->all());
        $cat = products_category::where('id', $id)->first();
        $cat->name = $request->cat_name;
        $cat->update();
        return redirect()->back();
    }

    public function category_delete($id)
    {
        $cat = products_category::where('id', $id)->first();
        $cat->delete();
        return redirect()->back();
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
                    $action_product = ProductVariations::where("id", $product)->first();
                    $action_product->enable = 1;
                    $action_product->update();
                }
            }

        } elseif ($request->action_Type = "Disable") {
            foreach ($request->product_id as $product) {
                if ($product != "on") {
                    $action_product = ProductVariations::where("id", $product)->first();
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

    public function focproduct()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $foc = Freeofchare::with('emp', 'variant')
                ->get();
        }else{
            $foc = Freeofchare::with('emp', 'variant')
                ->where('branch_id',$auth->office_branch_id)
                ->get();
        }
        return view('product.foc', compact('foc'));
    }

    public function export()
    {
        return Excel::download(new ProductExport(), 'products.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductImport(), $request->file('import'));
            return redirect()->route('products.index')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect()->route('products.index')->with('error', $e->getMessage());
        }
    }
    public function cat_import(Request $request)
    {
            Excel::import(new ProductCategoryImport(), $request->file('import'));
            return redirect()->back();
    }
    public function itemlist(){
        $variantions = ProductVariations::with('supplier')->get();
        return view('product.itemlist',compact('variantions'));
    }
    public function item_import(Request $request){
            Excel::import(new ItemImport(), $request->file('import'));

    }
}
