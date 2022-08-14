<?php

namespace App\Http\Controllers;

use App\Models\OfficeBranch;
use App\Models\Region;
use App\Models\SaleZone;
use App\Models\ShopLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ShopRegister extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { $user=Auth::guard('employee')->user();

        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $shops=ShopLocation::with('employee')->get();
        }else{
            $shops=ShopLocation::with('employee')->where('branch_id',$user->office_branch_id)->get();
        }

        return view('sale.SaleWay.Shop.index',compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth=Auth::guard('employee')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $branches=OfficeBranch::all();
            $region=Region::all();
            $zones=SaleZone::all();
        }else{
            $branches=OfficeBranch::where('id',$auth->office_branch_id)->get();
            $region=Region::where('branch_id',$auth->office_branch_id)->get();
            $zones=[];
            foreach ($region as $reg){
                $zone=SaleZone::where('region_id',$reg->id)->get();
                if(count($zone)!=0){
                    foreach ($zone as $z){
                        array_push($zones,$z);
                    }
                }
            }
        }
        return view('sale.SaleWay.Shop.create',compact('branches','region','zones'));
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
        $this->validate($request,[

            'name'=>'required',
            'location'=>'required',
            'customer_id'=>'nullable',
            'picture'=>'nullable',
            'contact'=>'required',
            'phone'=>'required',
            'description'=>'nullable',
            'region_id'=>'required',
            'zone_id'=>'nullable',
            'branch_id'=>'required'

        ]);
        $data=$request->all();
        if ($request->picture != null) {
            $image = $request->file('picture');
            $input['imagename'] = Str::random(10).time().'.'.$image->extension();
            $filePath = public_path('/img/profiles');
            $img = Image::make($image->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);
        $data['picture']=$input['imagename'];
        }
        ShopLocation::create($request->all());
        return redirect('shop')->with('success','Added new shop');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop=ShopLocation::where('id',$id)->first();
        return view('sale.SaleWay.Shop.show',compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop=ShopLocation::where('id',$id)->firstorFail();
        return view('sale.SaleWay.Shop.edit',compact('shop'));
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
        $shop=ShopLocation::where('id',$id)->firstorFail();
        $shop->update($request->all());
        return redirect('shop')->with('success','Updated shop');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
