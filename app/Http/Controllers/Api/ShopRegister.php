<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    {
        $user=Auth::guard('api')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $shops=ShopLocation::with('employee','branch','region','zone')->get();
            $branch=OfficeBranch::all();
            $region=Region::all();
            $zones=SaleZone::all();
        }else{
            $shops=ShopLocation::with('employee','branch','region','zone')->where('branch_id',$user->office_branch_id)->get();
            $branch=OfficeBranch::where('id',$user->office_branch_id)->get();
            $region=Region::where('branch_id',$user->office_branch_id)->get();
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

        return response()->json(['shops'=>$shops,'branch'=>$branch,'region'=>$region,'zone'=>$zones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth=Auth::guard('api')->user();
        if($auth->role->name=='Super Admin'||$auth->role->name=='CEO'){
            $branch=OfficeBranch::all();
        }else{
            $branch=OfficeBranch::where('id',$auth->office_branch_id)->get();
        }
        return response()->json(['branch'=>$branch]);
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
            'img'=>'nullable',
            'contact'=>'required',
            'phone'=>'required',
            'description'=>'nullable',
            'branch_id'=>'required',
            'region_id'=>'required',
            'zone_id'=>'required'

        ]);
        $data=$request->all();
        $data['emp_id']=Auth::guard('api')->user()->id;
        if ($request->img != 0) {
            $image = $request->file('img');
            $input['imagename'] = Str::random(10).time().'.'.$image->extension();
            $filePath = public_path('/img/profiles');
            $img =Image::make($image->path());
            $img->resize(110, 110, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);
            $data['picture']=$input['imagename'];
        }
        ShopLocation::create($data);
        return response()->json(['message'=>'Added new shop']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop=ShopLocation::with('employee','branch','region','zone')->where('id',$id)->first();
        $position=[];
         $location=explode(',',$shop->location);
        $position['lat']=$location[0];
        $position['lng']=$location[1];
        return response()->json(['shop'=>$shop,'location'=>$position]);
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
        return response()->json(['shop'=>$shop]);
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
        return response()->json(['shop'=>$shop]);
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
