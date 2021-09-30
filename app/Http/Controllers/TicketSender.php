<?php

namespace App\Http\Controllers;

use App\Models\ticket;
use App\Models\ticket_sender;
use Illuminate\Http\Request;

class TicketSender extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sender_info=ticket_sender::all();
        $ticket=ticket::all();
       return  view('ticket.sender',compact('sender_info','ticket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status_color=['New'=>'#49d1b6','Open'=>'#e84351','Close'=>'#4e5450','Pending'=>'#f0ed4f','Progress'=>'#2333e8','Complete'=>'#18b820'];
        $sender_info=ticket_sender::where('id',$id)->firstorFail();
        $ticket=ticket::with("ticket_status",'ticket_priority','sender_info','created_by')->where('customer_id',$id)->get();
        return view('ticket.senderdetail',compact('status_color','sender_info','ticket'));
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
}
