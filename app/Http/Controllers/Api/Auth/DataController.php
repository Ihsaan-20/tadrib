<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Program;


class DataController extends Controller
{
    public function showCoachData()
    {
        // return response()->json(['status' => true, ',msg' => 'Okay']);
        $Coachs = Coach::latest()->get();
        

        if ($Coachs->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'Coachs' => $Coachs
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }


    
}
