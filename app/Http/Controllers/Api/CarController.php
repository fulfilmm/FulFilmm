<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\CarData;
use App\Models\MaintainSchedule;
use App\Models\MaintainRecord;

class CarController extends Controller
{
    
    public function index()
    {
        $cars = CarData::with('status' , 'routines')
                ->orderBy('id', 'desc') -> get();

        foreach ( $cars as $file) {
            $file->attach = json_decode($file->attach);
        }
        $employees=Employee::with('roles')->get();
//        $manager=[];
//        $employee=[];
//        $driver=[];
//        $admin_manager=[];
//        foreach ($employees as $emp){
//            if($emp->role->name=='Sale Manager'||$emp->role->name=='Stock Manager'||$emp->role->name=='Finance Manager'
//            ||$emp->role->name=='Hr Manager'||$emp->role->name=='Customer Service Manager'||$emp->role->name=='General Manager'){
//                array_push($manager,$emp);
//
//            }elseif($emp->role->name=='Sale'||$emp->role->name=='Agent'||$emp->role->name=='Employee'||$emp->role->name=='Accountant'||$emp->role->name=='Cashier'||$emp->role->name=='Purchaser'){
//                array_push($employee,$emp);
//            }elseif ($emp->role->name=='Admin Manager'||$emp->role->name=='CEO'||$emp->role->name=='Super Admin'||$emp->role->name=='Car Admin'){
//             array_push($admin_manager,$emp);
//            }
//            elseif ($emp->role->name=='Car Driver'){
//             array_push($driver,$emp);
//            }
//        }
//        $all_emp=['driver'=>$driver,'manager'=>$manager,'employee'=>$employee,'admin'=>$admin_manager];
        return response() -> json(['cars' => $cars,'employee'=>$employees]);
        
    }

  
    public function store(Request $request)
    {
        $request -> validate([
            'license_no' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'manufacture' => 'required',
            'engine' => 'required',
            'horsepower' => 'required',
            'chassis' => 'required',
            'kilometer' => 'nullable',
            'upd_kilometer' => 'nullable',
            'license_issue_date' => 'nullable',
            'license_renew_date' => 'nullable',
            
            'fuel_type' => 'required',
            'seat' => 'required',
            'purchase_value' => 'required',
            'car_type' => 'required',
            'contract_date' => 'nullable',
            'org_owner_name' => 'nullable',
            'renew_date' => 'nullable',
            'contract' => 'nullable',
            'attach' => 'nullable',
            //'contract' => 'required | mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip,png',
            'description' => 'nullable',
        ]);


        if ($request->hasfile('contract')) {
            $file = $request->file('contract');
            $filename = Uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path() . '/upload/car_list/contract', $filename);
        }
        else 
        {
            $filename = Null ;
        }

        if( $request->hasfile('attach')){

            $data = [];
            foreach( $request -> file('attach') as $file ){

                $name = Uniqid().'_'.$file -> getClientOriginalName();
                $file -> move(public_path().'/upload/car_list/attach', $name);
                $data[] = $name;
                $result = json_encode($data);
            }
        }

        else {
            $result = Null;
        }

       

     

        $data = CarData::create ([
            'license_no' => $request -> license_no,
            'brand' => $request -> brand,
            'model' => $request -> model,
            'manufacture' => $request -> manufacture,
            'engine' => $request -> engine,
            'horsepower' => $request -> horsepower,
            'chassis' => $request -> chassis,
            'kilometer' => $request -> kilometer,
            'upd_kilometer' => $request -> upd_kilometer,
            'license_issue_date' => $request -> license_issue_date,
            'license_renew_date' => $request-> license_renew_date,
            
            'fuel_type' => $request -> fuel_type,
            'seat' => $request -> seat,
            'purchase_value' => $request -> purchase_value,
            'car_type' => $request->car_type,
            'contract_date' => $request -> contract_date,
            'org_owner_name' => $request -> org_owner_name,
            'renew_date' => $request -> renew_date,
            'contract' => $filename,
            'attach' => $result,
            'description' => $request -> description,
        ]);

        return response()->json(['message' => 'New Data Created']);
    }

   
    public function show($id)
    {
        $data = CarData::with('status' , 'routines')
                -> find($id);
                
        $data->attach = json_decode($data->attach);

        return $data;
    }

  
    public function update(Request $request, $id)
    {

        $request -> validate([
            'license_no' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'manufacture' => 'nullable',
            'kilometer' => 'nullable',
            'upd_kilometer' => 'nullable',
            'license_issue_date' => 'nullable',
            'license_renew_date' => 'nullable',
           
            'fuel_type' => 'nullable',
            'seat' => 'nullable',
            'purchase_value' => 'nullable',
            'car_type' => 'nullable',
            'contract_date' => 'nullable',
            'org_owner_name' => 'nullable',
            'renew_date' => 'nullable',
            'contract' => 'nullable',
            //'contract' => 'nullable | mimes:pdf,xlsx,doc,docx,jpg,jpeg,ppt,bip',
            'description' => 'nullable',
        ]);

        $data = CarData::find($id);

        $data -> update( $request -> only ('license_no' , 'brand', 'model', 'manufacture', 'kilometer', 'upd_kilometer', 
                                            'license_issue_date', 'license_renew_date', 'status', 'fuel_type', 'seat', 
                                            'purchase_value', 'car_type', 'contract_date','org_owner_name', 'renew_date',
                                            'contract', 'description'));
        
        return $data;


    }

    
    public function destroy($id)
    {
        $data = CarData::find($id);
        $data -> delete();

        $schedule = MaintainSchedule::where('car_id' , $id);
        $schedule -> delete();

        $record = MaintainRecord::where('car_id', $id);
        $record -> delete();

    }
}
