<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Models\MaintainCheck;
use App\Models\MaintainSchedule;

class MaintainCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $data = MaintainSchedule::orderBy('id', 'desc') ->get();
 
        return response() -> json(['data' , $data]);
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
            'car_id' => 'required',
            'case' => 'required',
            'driver' => 'nullable',
            'workshop' => 'nullable',
            'kilometer' => 'nullable',
            'attaches' => 'nullable',
            //'total' => 'nullable',
            'note' => 'nullable',
        ]);

        if( $request->hasfile('attaches')){

            $data = [];
            foreach( $request -> file('attaches') as $file ){

                $name = Uniqid().'_'.$file -> getClientOriginalName();
                $file -> move(public_path().'/upload/maintain/maintain_check/attaches/', $name);
                $data[] = $name;
                $result = json_encode($data);
            }
        }

        else {
            $result = Null;
        }

        $data = MaintainSchedule::create ([
            'car_id' => $request -> car_id,
            'case' => $request -> case,
            'driver' =>  $request -> driver,
            'workshop' => $request -> workshop,
            'kilometer' => $request -> kilometer,
            'attaches' => $result,
            //'total' => $request -> total,
            'note' => $request -> note,
        ]);

        return response() -> json(['message' => 'New Record Created']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routine = MaintainSchedule::find($id);
        $routine-> attaches = json_decode($routine -> attaches);
        
        $routine -> case = json_decode($routine -> case);

        return response() -> json(['routine' => $routine]);
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
        $request -> validate([
            'case' => 'nullable',
            'driver' => 'nullable',
            'workshop' => 'nullable',
            'kilometer' => 'nullable',
            'total' => 'nullable',
            'check' => 'nullable',
            'note' => 'nullable',
        ]);

        $data = MaintainSchedule::find($id);

        $data -> update ( $request -> only('case','driver','workshop','kilometer','total','check','note'));

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MaintainSchedule::find($id);
        $data -> delete();
    }
}
