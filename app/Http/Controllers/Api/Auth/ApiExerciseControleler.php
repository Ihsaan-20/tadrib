<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;
use Illuminate\Support\Facades\Validator;

class ApiExerciseControleler extends Controller
{
    public function getAllExercises()
    {
       $exercises = Exercise::latest()->get();
       if($exercises){
        return response()->json([
            'status' => 200,
            'message' => 'Data fetched',
            'exercises' => $exercises
        ], 200);
       }else{
        return response()->json([
            'status' => 404,
            'message' => 'No data found...',
        ], 404);
       }
       
    }
    public function storeExercise(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'text_bio' => 'required',
            'repetitions' => 'required|integer',
            'video' => 'required|mimes:mp4,avi,mov,wmv|max:10240',
            'coach_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Saving logic
        $videoPath = null;

        if ($request->hasFile('video')) {
            $destination = 'public/exercise_videos';
            $videoFile = $request->file('video');
            $videoFileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $videoPath = $videoFile->storeAs($destination, $videoFileName);
        }

        $stored = Exercise::create([
            'name' => $request->input('name'),
            'description_video' => $videoFileName,
            'text_bio' => $request->input('text_bio'),
            'repetitions' => $request->input('repetitions'),
        ]);

        if($stored){
            return response()->json([
                'message' => 'Exercise created successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }

    public function editExercise(int $id)
    {
        $exercise = Exercise::findOrFail($id);
        if($exercise){
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'exercise' => $exercise
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }

    public function updateExercise(Request $request, int $id)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'text_bio' => 'required',
            'repetitions' => 'required|integer',
            'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'coach_id'=>'nullable'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $exercise = Exercise::find($id);
            // Check if the exercise is found
            if ($exercise) {
                // Saving logic
                $exerciseData = [
                    'name' => $request->input('name'),
                    'text_bio' => $request->input('text_bio'),
                    'repetitions' => $request->input('repetitions'),
                    'coach_id'=>$request->coach_id,
                ];
    
                // Check if a new video file is provided
                if ($request->hasFile('video')) {
                    $destination = 'public/exercise_videos';
                    $videoFile = $request->file('video');
                    $videoFileName = uniqid() . $videoFile->getClientOriginalName();
                    $path = $videoFile->storeAs($destination, $videoFileName);
    
                    // Update the video path in the database
                    $exerciseData['description_video'] = $videoFileName;
                }
    
                // Update the exercise data
                $exercise->update($exerciseData);
    
                return response()->json(['status' => 200, 'message' => 'Data updated']);
            } else {
                return response()->json(['status' => 404,'message' => 'No data found...'], 404);
            }
        }
    }

    public function showExercise(int $id)
    {
        $exercise = Exercise::findOrFail($id);
        if($exercise){
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'exercise' => $exercise
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }

    public function destroyExercise(int $id)
    {
        try {
            $exercise = Exercise::findOrFail($id);
            $exercise->delete();

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
    }


    





}//end class;




