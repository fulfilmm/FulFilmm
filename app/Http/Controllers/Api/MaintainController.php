<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarData;
use App\Models\MaintainRecord;

class MaintainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = CarData::all();

        $maintains = MaintainRecord::with('car')
                    ->orderBy('id', 'desc')
                    ->get();

        return response() -> json(['cars' => $cars ,
                                    'maintains' => $maintains]);
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
            'status' => 'required',
            'car_id' => 'required',
            'case' => 'required',
            'description' => 'nullable',
            'kilometer' => 'required',
            'workshop' => 'required',
            'service_date' => 'required',
            'driver' => 'required',
            'attaches' => 'required',
            'total' => 'required',
 
        ]);

        if( $request->hasfile('attaches')){

            $data = [];
            foreach( $request -> file('attaches') as $file ){

                $name = Uniqid().'_'.$file -> getClientOriginalName();
                $file -> move(public_path().'/upload/maintain/attach/', $name);
                $data[] = $name;
                $result = json_encode($data);
            }
        }

        $maintain = MaintainRecord::create ([
            'status' => $request -> status ,
            'car_id' =>$request -> car_id,
            'case' => $request -> case,
            'description' => $request -> description,
            'kilometer' => $request -> kilometer,
            'workshop' => $request -> workshop,
            'service_date' => $request -> service_date,
            'driver' => $request -> driver,
            'attaches' => $result,
            'total' => $request -> total,

        ]);

        return $maintain;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $maintain = MaintainRecord::find($id);
        $maintain->attaches = json_decode($maintain->attaches);
        $maintain->case = json_decode($maintain->case);
        

        $car = CarData::where('id', $id) ->get();
       
        return response() -> json(['car' => $car ,
                            'maintain' => $maintain]);
    }

   
    public function update(Request $request, $id)
    {
        $request -> validate ([
            'status' => 'nullable',
            'car_id' =>'nullable',
            'case' => 'nullable',
            'description' => 'nullable',
            'kilometer' => 'nullable',
            'workshop' => 'nullable',
            'service_date' => 'nullable',
            'driver' => 'nullable',
            'attaches' => 'nullable',
            'check' => 'nullable',

        ]);

        $maintain = MaintainRecord::find($id);

        $maintain -> update( $request -> only ('status','case','description', 'kilometer', 
                                                'workshop', 'service_date', 'driver','check'));
        
        return $maintain;
    
    }

   
    public function destroy($id)
    {
        $maintain = MaintainRecord::find($id);
        $maintain -> delete();
    }
}
