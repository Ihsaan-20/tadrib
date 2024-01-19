<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Tag;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllPrograms(Request $request)
    {
        $keyword = $request->input('search');

        $query = Program::query();

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('progress', 'like', "%$keyword%");
        }

        $Programs = $query->latest()->get();
$train=[];
$equip=[];
$work=[];
        if ($Programs->isNotEmpty()) {
            foreach($Programs as $p){
                $training=json_decode($p->training_type);
                foreach($training as $t){
                    $tag=Tag::find($t);
                  
                    $train[]=$tag->tag;
                }
               
                $p['training_type']=$train;


                $equipment=json_decode($p->tag_equipment);
                foreach($equipment as $t){
                    $tag=Tag::find($t);
                  
                    $equip[]=$tag->tag;
                }
               
                $p['tag_equipment']=$equip;


                $workout=json_decode($p->number_of_workout);
                foreach($workout as $t){
                    $tag=Workout::find($t);
                  
                    $work[]=$tag->name;
                }
               
                $p['number_of_workout']=$work;
               
            }


            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'Programs' => $Programs
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
    public function storeNewProgram(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'introductory_video' => 'required|mimes:mp4,mov,ogg|max:102400',
            'thumbnail' => 'required|image',
            'text_bio' => 'required',
            'training_type' => 'required',
            'tag_equipment'=>'required',
            'coach_id'=>'required',
            'duration_weeks'=>'required',
            'price_usd'=>'required',
            'level'=>'required',
            'number_of_workout'=>'required',
            'external_video'=>'required',

        ]);
$input=$request->all();
       $video=rand(000000,456423).'.'.$request->introductory_video->extension();
       $path=$request->introductory_video->storeAs('video',$video,'public');
       $input['introductory_video']=$path;

       $image=rand(000000,456423).'.'.$request->thumbnail->extension();
       $path=$request->thumbnail->storeAs('video',$image,'public');
       $input['thumbnail']=$path;

       $input['training_type']=json_encode($request->training_type);
       $input['tag_equipment']=json_encode($request->tag_equipment);
       $input['number_of_workout']=json_encode($request->number_of_workout);
        $program = Program::create($input);
            if($program)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Program added successfully!',
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
    

    /**
     * Display the specified resource.
     */
    public function showProgram($id)
    {
        $program = Program::find($id);
        $train=[];
        $equip=[];
        $work=[];
        if ($program) {
            $training=json_decode($program->training_type);
            foreach($training as $t){
                $tag=Tag::find($t);
              
                $train[]=$tag->tag;
            }
           
            $program['training_type']=$train;


            $equipment=json_decode($program->tag_equipment);
            foreach($equipment as $t){
                $tag=Tag::find($t);
              
                $equip[]=$tag->tag;
            }
           
            $program['tag_equipment']=$equip;


            $workout=json_decode($program->number_of_workout);
            foreach($workout as $t){
                $tag=Workout::find($t);
              
                $work[]=$tag->name;
            }
           
            $program['number_of_workout']=$work;
            return response()->json([
                'status' => 200,
                'message' => 'Program record is available!',
                'program' => $program
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Program record not found!',
            ], 404);
        }
    }

     /**
     * Edit the specified resource in storage.
     */
    public function editProgramData($id)
    {
        $program = Program::find($id);

        if($program)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Program record is available!',
                'program' => $program
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Program record not found!',
            ], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateProgramData(Request $request, $id)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'progress' => 'required',
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
            $Program = Program::find($id);


            if($Program)
            {
                $Program->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Program updated successfully!',
                ], 200);
            }
            else
            {
                return response()->json([
                    'status' => 404,
                    'message' => 'Program record not found!',
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyProgram($id)
    {
        $program = Program::find($id);

        if($program)
        {
            $program->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Program deleted successfully!',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'Program record not found!',
            ], 404);
        }
    }
}
