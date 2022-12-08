<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(){
        $warhouse=Warehouse::with('branch')->get();
        return response()->json(['con'=>true,'result'=>$warhouse]);
    }
}
