<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\SaleGroup;
use App\Models\SaleGroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleGroupController extends Controller
{
    public function index(){
        $user=Auth::guard('employee')->user();
        if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
            $groups=SaleGroup::all();
        }else{
            $groups=SaleGroup::where('branch_id',$user->office_branch_id)->get();
        }
        return view('sale.group.index',compact('groups'));
    }
    public function create(){
       $user=Auth::guard('employee')->user();
       if($user->role->name=='Super Admin'||$user->role->name=='CEO'){
           $employee=Employee::all();
       }else{
           $employee=Employee::where('office_branch_id',$user->office_branch_id)->get();
       }
        return view('sale.group.create',compact('employee'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'branch_id'=>'required'
        ]);
        $data['name']=$request->name;
        $data['emp_id']=Auth::guard('employee')->user()->id;
        $data['branch_id']=$request->branch_id;
       $group=SaleGroup::create($data);
       foreach ($request->emp_id as $key=>$val){
           $this->member($group->id,$val);
       }
       return redirect(route('salegroup.index'))->with('success','Added new sale group');
    }
    public function edit($id){

    }
    public function update(Request $request,$id){

    }
    public function show($id){
        $group=SaleGroup::where('id',$id)->first();
        $members=SaleGroupMember::with('emp')->where('group_id',$id)->get();
        $employee=Employee::all();
        return view('sale.group.show',compact('group','members','employee'));
    }
    public function member($group_id,$emp_id){
        $data['group_id']=$group_id;
        $data['emp_id']=$emp_id;
        SaleGroupMember::create($data);
    }
    public function add_member(Request $request){
        foreach ($request->emp_id as $key=>$val){
            $exists=SaleGroupMember::where('group_id',$request->group_id)->where('emp_id',$val)->first();
            if($exists==null){
                $this->member($request->group_id,$val);
            }
        }
        return redirect(route('salegroup.show',$request->group_id))->with('success','Added new member');
    }
    public function remove_member(Request $request){
        foreach ($request->member_id as $id){
            $sale_group_member=SaleGroupMember::where('id',$id)->first();
            $sale_group_member->delete();
        }
        return redirect(route('salegroup.show',$request->group_id))->with('success',count($request->member_id).' member removed');
    }
}
