<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcommerceBanner;


class ProductBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = EcommerceBanner::all() -> orderBy('id', 'desc');

        return $data;

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
            'banner' => 'required',
            'title' => 'nullable',
        ]);

        if( $request -> hasfile('banner')) {
            $file = $request -> file('banner');
            $filename = Uniqid().'_'.$file-> getClientOriginalName();
            $file -> move( public_path(). '/ecommerce/photos/banner/', $filename);
        }

        $data = EcommerceBanner::create ([
            'banner' => $filename,
            'title' => $request -> title,
        ]);

        return response() -> json(['message' => 'New Banner Added']);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = EcommerceBanner::find($id);
        $data -> delete();
    }
}
