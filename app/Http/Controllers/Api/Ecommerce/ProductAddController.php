<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcommerceProductAdd;

class ProductAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productAdds = EcommerceProductAdd::with('product')
                        ->get();

        foreach( $productAdds as $file){
            $file -> photos = json_decode($file -> photos);
        }
        
        return response() -> json(['productAdds' => $productAdds]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate ([
            'product_id' => 'required',
            'cover' => 'required',
            'photos' => 'required',
            'price' => 'required',
            'description' => 'nullable',
        ]);

        if( $request -> hasfile('cover')){
            $file = $request -> file('cover');
            $filename = Uniqid().'_'.$file -> getClientOriginalName();
            $file -> move( public_path(). '/ecommerce/photos/cover/', $filename);  
        }

        if( $request -> hasfile('photos')) {
            $data = [];

            foreach( $request -> file('photos') as $file) {
                $name = Uniqid().'_'.$file -> getClientOriginalName();
                $file -> move( public_path().'/ecommerce/photos/images/', $name);
                $data[] = $name;

                $result = json_encode($data);
            }
        }

        $data =  EcommerceProductAdd::create ([
            'product_id' => $request -> product_id,
            'cover' => $filename,
            'photos' => $result,
            'price' => $request -> price,
            'description' => $request -> description,
        ]);

        return response() -> json(['message' => 'New Datas Added']);
    }

  
    public function show($id)
    {
        $data = EcommerceProductAdd::with('product')
                -> find($id);
        $data -> photos = json_decode($data -> photos);

        return $data;
    }

   
    public function update(Request $request, $id)
    {
        $request -> validate ([
            'price' => 'nullable',
            'description' => 'nullable',
        ]);

        $data = EcommerceProductAdd::find($id);

        $data -> update( $request -> only('price', 'description'));

        return $data;
    }

 
    public function destroy($id)
    {
        $data = EcommerceProducttAdd::find($id);
        $data -> delete();
    }
}
