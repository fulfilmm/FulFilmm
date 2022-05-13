<?php

namespace App\Http\Controllers;

use App\Imports\ProductBrandImport;
use App\Models\Brand;
use http\Exception;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand=Brand::all();
        return view('product.brand',compact('brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name'=>'required',
        ]);
        if (isset($request->brand_logo)) {
                $input['imagename'] =\Illuminate\Support\Str::random(10).time().'.'.$request->file('brand_logo')->extension();

                $filePath = public_path('/product_picture/');

                $img = Image::make($request->file('brand_logo')->path());
                $img->resize(400, 800, function ($const) {
                    $const->aspectRatio();
                })->save($filePath.'/'.$input['imagename']);
                $data[] = $input['imagename'];
            $data['brand_logo']=$input['imagename'];
            }

        $data['name']=$request->name;
        Brand::create($data);
        return redirect(route('product_brand.index'))->with('success','Brand add success!');
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

        if (isset($request->brand_logo)) {
            $input['imagename'] =\Illuminate\Support\Str::random(10).time().'.'.$request->file('brand_logo')->extension();

            $filePath = public_path('/product_picture/');

            $img = Image::make($request->file('brand_logo')->path());
            $img->resize(400, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);
            $data[] = $input['imagename'];
            $data['brand_logo']=$input['imagename'];
        }

        $data['name']=$request->name;
        $brand=Brand::where('id',$id)->first();
        $brand->update($data);
        return redirect()->back()->with('success','Brand Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::where('id',$id)->first();
        $brand->delete();
        return redirect()->back()->with('error','Deleted Successful !');
    }
    public function import(Request $request){
        try {
            Excel::import(new ProductBrandImport(), $request->file('import'));
            return redirect('product_brand')->with('success', __('alert.import_success'));
        } catch (Exception $e) {
            return redirect('product_brand')->with('error', $e->getMessage());
        }
    }
}
