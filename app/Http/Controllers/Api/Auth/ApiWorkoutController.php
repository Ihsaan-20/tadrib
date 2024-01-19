<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Workout;
use App\Models\Exercise;
use App\Models\Tag;

class ApiWorkoutController extends Controller
{
    public function getAllWorkout()
    {
       $workouts = Workout::latest()->get();
       if($workouts){
        return response()->json([
            'status' => 200,
            'message' => 'Data fetched',
            'workouts' => $workouts
        ], 200);
       }else{
        return response()->json([
            'status' => 404,
            'message' => 'No data found...',
        ], 404);
       }
       
    }//end here;


    public function storeWorkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'introductory_video' => 'required', // Adjust the allowed video file types and size
            'text_bio' => 'required',
            'estimated_duration_hours' => 'required',
            'coach_id'=>'required',
            'rest' => 'required',
            'tags.*' => 'required',
            'number_of_exercises.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $input = $request->all();
        $input['exercises'] = json_encode($request->exercises);

        $set = Workout::create($input);

        return $set
            ? response()->json(['status' => 200, 'message' => 'Workout created successfully!'], 200)
            : response()->json(['status' => 404, 'message' => 'Failed to create workout.'], 404);
    }//end here;



    public function editWorkout($id)
    {
        $tags = Tag::where('type', 'equipment')->get();
        $exercises = Exercise::all();
        $workout = Workout::find($id);

        if (!$workout) {
            return response()->json(['status' => 404, 'message' => 'Workout not found.'], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'tags' => $tags,
                'exercises' => $exercises,
                'workout' => $workout,
            ],
        ], 200);
    }



    public function updateWorkout(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'introductory_video' => 'required', // Adjust the allowed video file types and size
            'text_bio' => 'required',
            'estimated_duration_hours' => 'required',
            'rest' => 'required',
            'tags.*' => 'required',
            'number_of_exercises.*' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $workout = Workout::findOrFail($id);

        if (!$workout) {
            return response()->json(['status' => 404, 'message' => 'Workout not found.'], 404);
        }

        $input = $request->all();
        $input['tags'] = json_encode($request->tags);
        $input['number_of_exercises'] = json_encode($request->number_of_exercises);
        $input['name'] = $input['name'];

        if ($request->hasFile('introductory_video')) {
            $destination = 'public/introductory_video';
            $introductoryVideo = $request->file('introductory_video');
            $introductoryVideoName = uniqid() . $introductoryVideo->getClientOriginalName();
            $path = $introductoryVideo->storeAs($destination, $introductoryVideoName);
            $input['introductory_video'] = $introductoryVideoName;
        }

        $input['text_bio'] = $input['text_bio'];
        $input['estimated_duration_hours'] = $input['estimated_duration_hours'];
        $input['rest'] = $input['rest'];

        $workout->update($input);

        return response()->json([
            'status' => 200,
            'message' => 'Workout updated successfully!',
            'data' => $workout,
        ], 200);
    }//end here;


    public function showWorkout($id)
    {
        $workout = Workout::find($id);
        if ($workout) {
            return response()->json(['status' => 200, 'data' => $workout], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'Set not found.'], 404);
        }
    }//end here;


    public function destroyWorkout(int $id)
    {
        try {
            $workout = Workout::findOrFail($id);
            $workout->delete();

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
