<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SaleGroup;
use App\Models\SaleGroupMember;
use App\Models\SalesWayAssign;
use App\Models\SaleWay;
use App\Models\way_assign_shop;
use App\Models\WayReachShop;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WayAssignController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use NotifyTrait;
    public function index()
    {
        $user=Auth::guard('employee')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $assgin_way=SalesWayAssign::with('way','group','emp','assign_employee')->get();
        }else{
            $assgin_way=SalesWayAssign::with('way','group','emp','assign_employee')->where('branch_id',$user->office_branch_id)->get();
        }

        return response()->json(['assign_way'=>$assgin_way]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=Auth::guard('employee')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $groups=SaleGroup::all();
            $ways=SaleWay::all();
            $employees=Employee::all();
        }else{
            $groups=SaleGroup::where('branch_id',$user->office_branch_id)->get();
            $ways=SaleWay::where('branch_id',$user->office_branch_id)->get();
            $employees=Employee::where('office_branch_id',$user->office_branch_id)->get();
        }
        return response()->json(['groups'=>$groups,'ways'=>$ways,'employees'=>$employees]);
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
            'way_id'=>'required',
            'branch_id'=>'required',
            'type'=>'required',

        ]);
        $data['way_id']=$request->way_id;
        $data['type']=$request->type;
        if($request->type==1){
            $data['group_id']=$request->group_id;
        }else{
            $data['emp_id']=$request->emp_id;
        }
        $data['assigned_emp']=Auth::guard('employee')->user()->id;
        $data['start_date']=$request->start_date;
        $data['branch_id']=$request->branch_id;
        $assign=SalesWayAssign::create($data);
        $shops=way_assign_shop::where('way_id',$request->way_id)->get();
        foreach ($shops as $item){
            $way['assign_id']=$assign->id;
            $way['shop_id']=$item->shop_id;
            WayReachShop::create($way);
        }
        if($request->type==1){
            $salegroup=SaleGroupMember::where('group_id',$request->group_id)->get();
            foreach ($salegroup as $memember){
                $this->addnotify($memember->emp_id,'noti','You have assigned a new sale way to your sale group','assignsaleway/'.$assign->id,Auth::guard('employee')->user()->id);
            }
        }else{
            $this->addnotify($request->emp_id,'noti','You have assigned a new sale way to you','assignsaleway/'.$assign->id,Auth::guard('employee')->user()->id);
        }
        return response()->json(['message'=>'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignway=SalesWayAssign::with('way','group','emp','assign_employee')->where('id',$id)->first();
        $shop=WayReachShop::with('shop')->where('assign_id',$id)->get();
//        dd($shop);
        return response()->json(['assignway'=>$assignway,'shop'=>$shop]);
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
        //
    }
    public function check(Request $request,$id){
        $shopreach=WayReachShop::where('id',$id)->first();
        $shopreach->emp_location=$request->emp_location;
        $shopreach->emp_id=Auth::guard('employee')->user()->id;
        $shopreach->reach=1;
        $shopreach->update();
        return response()->json(['message','Checkin success']);
    }
}
