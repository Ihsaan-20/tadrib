<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllCoachs(Request $request)
    {
        $keyword = $request->input('search');

        $query = Coach::query();

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('phone_number', 'like', "%$keyword%")
                ->orWhere('bio', 'like', "%$keyword%");
        }

        $coachs = $query->latest()->get();

        if ($coachs->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'Coachs' => $coachs
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeNewCoach(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'bio' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
        else
        {
            $Coachs = Coach::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'bio' => $request->bio
            ]);

            if($Coachs)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Coach added successfully!',
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 500,
                    'message' => 'Opps something went wrong!',
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function showCoach($id)
    {
        $coachs = Coach::find($id);

        if ($coachs) {
            return response()->json([
                'status' => 200,
                'message' => 'Coach record is available!',
                'coach' => $coachs
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Coach record not found!',
            ], 404);
        }
    }


      /**
     * Edit the specified resource in storage.
     */
    public function editCoachData($id)
    {
        $coach = Coach::find($id);

        if($coach)
        {
            return response()->json([
                'status' => 200,
                'message' => 'coach record is available!',
                'coach' => $coach
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'coach record not found!',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCoachData(Request $request,$id)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'bio' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
        else
        {
            $Coach = Coach::find($id);


            if($Coach)
            {
                $Coach->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'bio' => $request->bio
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Coach updated successfully!',
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Coach record not found!',
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCoach($id)
    {
        $coach = Coach::find($id);

        if($coach)
        {
            $coach->delete();
            return response()->json([
                'status' => 200,
                'message' => 'coach deleted successfully!',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'coach record not found!',
            ], 404);
        }
    }
}
