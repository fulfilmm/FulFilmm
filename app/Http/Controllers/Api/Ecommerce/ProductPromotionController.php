<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcommerceProductPromotion;

class ProductPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotion = EcommerceProductPromotion::with('promotionProduct')
                        ->get();
        
        return response() -> json(['promotion' => $promotion]);
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
            'promotion_price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'note' => 'nullable',
            'status' => 'required',
        ]);

        $data = EcommerceProductPromotion::create([
            'product_id' => $request -> product_id,
            'promotion_price' => $request -> promotion_price,
            'start_date' => $request -> start_date,
            'end_date' => $request -> end_date,
            'note' => $request -> note,
            'status' => $request -> status,
        ]);

        return response() -> json(['message' => 'New Promotion Item Added']);


    }

   
    public function show($id)
    {
        $data = EcommerceProductPromotion::with('product')
                ->find($id);

        return $data;
    }

  
    public function update(Request $request, $id)
    {
        $request -> validate ([
            'promotion_price' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'note' => 'nullable',
            'status' => 'nullable',
        ]);

        $data = EcommerceProductPromotion::find($id);

        $data -> update( $request -> only('promotion_price', 'start_date', 'end_date','note', 'status'));

        return $data;
    }

    
    public function destroy($id)
    {
        $data = EcommerceProductPromotion::find($id);
        $data -> delete();
    }
}
