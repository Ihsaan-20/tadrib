<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Set;
class ApiSetController extends Controller
{
    public function getAllSets()
    {
       $sets = Set::latest()->get();
       if($sets){
        return response()->json([
            'status' => 200,
            'message' => 'Data fetched',
            'sets' => $sets
        ], 200);
       }else{
        return response()->json([
            'status' => 404,
            'message' => 'No data found...',
        ], 404);
       }
       
    }//end here;


    public function storeSet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'set_type' => 'required',
            'no_of_time' => 'required',
            'inter_set_rest' => 'required',
            'intra_set_rest' => 'required',
            'estimated_duration' => 'required',
            'workout_id' => 'required',
            'exercises.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $input = $request->all();
        $input['exercises'] = json_encode($request->exercises);

        $set = Set::create($input);

        return $set
            ? response()->json(['status' => 200, 'message' => 'Set created successfully!'], 200)
            : response()->json(['status' => 404, 'message' => 'Failed to create set.'], 404);
    }//end here;



    public function editSet(int $id)
    {
        $set = Set::findOrFail($id);
        if($set){
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'exercise' => $set
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }//end here;



    public function updateSet(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'set_type' => 'required',
            'no_of_time' => 'required',
            'inter_set_rest' => 'required',
            'intra_set_rest' => 'required',
            'estimated_duration' => 'required',
            'workout_id' => 'required',
            'exercises.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $set = Set::find($id);
            if (!$set) {
                return response()->json(['status' => 404, 'message' => 'Set not found.'], 404);
            }
            $input = $request->all();
            $input['exercises'] = json_encode($request->exercises);

            $set->update($input);
            return response()->json(['status' => 200, 'message' => 'Set updated successfully!'], 200);
        }

    }//end here;


    public function showSet($id)
    {
        $set = Set::find($id)
            ->join('workouts', 'workouts.id', 'workout_id')
            ->select('sets.*', 'workouts.name as workout_name')
            ->first();
        if ($set) {
            return response()->json(['status' => 200, 'data' => $set], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'Set not found.'], 404);
        }
    }//end here;


    public function destroySet(int $id)
    {
        try {
            $set = Set::findOrFail($id);
            $set->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data deleted successfully!',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }//end here;


}
