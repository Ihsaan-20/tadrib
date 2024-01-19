<?php

namespace App\Http\Controllers\AdminDashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\ProgramWorkoutExerciseSet;
use App\Models\ProgramWithExerciseSet; // new

class FormController extends Controller
{
    
    public function index()
    {
        $data = ProgramWithExerciseSet::latest()->get();
        $decode = json_decode($data);
        

        // foreach($decode as $de)
        // {
        //     echo '<pre>';
        //     foreach(json_decode($de->program) as $pro)
        //     {
        //         print_r($pro);
        //     }
        //     echo '</pre>';
        // }
        // print_r($decode[0]->program);
        // $program = $decode[0]->program;
        // $de = json_decode($program);
        // print_r($de);
        // die;
        // dd($data);
        return view('form.index', compact('decode'));

    }

    public function create()
    {
        return view('form.new_form');
    }


    public function store(Request $request)
    {
        // dd($request->all());        
        $programObj = $request->all();
        
        // setup program videos, and image path;
        $newProgramVideoPath = '';
        $newProgramImagePath = '';

        $video=rand(000000,456423).'.'.$programObj['program_intro_video']->extension();
        $path=$programObj['program_intro_video']->storeAs('program_intro_videos',$video,'public');
        $newProgramVideoPath = $path;
        $programObj['program_intro_video'] = $newProgramVideoPath;

        $image=rand(000000,456423).'.'.$programObj['program_profile']->extension();
        $path=$programObj['program_profile']->storeAs('program_profiles',$image,'public');
        $newProgramImagePath = $path;
        $programObj['program_profile'] = $newProgramImagePath;

        
        $newFilePaths = [];
        // set up workout files video/image;
        if ($request->has('workouts') && $programObj['workouts'] && $programObj['workouts'] !== null) {
            foreach ($programObj['workouts'] as &$workout) {
                $file = $workout['workout_video'];
                $newFileName = rand(000000, 456423) . '.' . $file->extension();
                $newFilePath = $file->storeAs('workout_videos', $newFileName, 'public');
                $workout['workout_video'] = $newFilePath;
                $newFilePaths[] = $newFilePath;
            }
        }


        // Create and save the model
        $programModel = new ProgramWithExerciseSet();
        $programModel->program = json_encode($programObj);
        $programModel->save();

        // Optionally, you can return a response
        return response()->json(['message' => 'Data stored successfully']);
    }



    // public function store(Request $request)
    // {
    //     $programObj = $request->all();

    //     // dd($programObj['workouts'][0]['workout_video']);
    
       
    
    //     foreach ($programObj['workouts'][0]['workout_video'] as $file) {
    //         $newFileName = rand(000000, 456423) . '.' . $file->extension();
    //         $newFilePath = $file->storeAs('workout_videos', $newFileName, 'public');
    //         $programObj['workouts'][0]['workout_video'] = $newFilePath;
    //     }
    
       
    //     dd($programObj);
 
    //     $programModel = new ProgramWithExerciseSet();
    //     $programModel->program = json_encode($programObj);
    //     $programModel->save();
    //     dd($programModel);
    //     return response()->json(['message' => 'Data stored successfully']);

    // }

    public function edit($id)
    {
        $json_data = ProgramWithExerciseSet::findOrFail($id);
        $data = json_decode($json_data);
        return $data;
        return view('form.edit', compact('data'));
    }

    // public function edit($id)
    // {
    //     $id = 4;
    //     $program = ProgramWithExerciseSet::findOrFail($id);
    //     $data = json_decode($program->column_name, true);
    //     return $data;
    //     // Pass the decoded data to the view
    //     return view('form.edit', compact('data'));
    // }



    public function destroy($id)
    {
        // return $id;
        $data = ProgramWorkoutExerciseSet::findOrFail($id);
        if($data)
        {   
            File::delete(public_path($data->program_intro_video));
            File::delete(public_path($data->program_profile));
            File::delete(public_path($data->workout_intro_video));
            File::delete(public_path($data->exercise_input_example));
            $data->delete();
            return redirect()->route('form.index')->with('success', 'Record and associated files deleted successfully.');
        }else{

            return redirect()->route('form.index')->with('error', 'Record not found!');

        }


        
    }


    // public function destroy($id)
    // {
    //     // return $id;
    //     $data = ProgramWorkoutExerciseSet::findOrFail($id);

    //     if ($data) {
    //         // Delete associated files if they exist
    //         $this->deleteFileIfExists('program-intro-videos/' . $data->program_intro_video);
    //         $this->deleteFileIfExists('program-thumbnails/' . $data->program_profile);
    //         $this->deleteFileIfExists('workout-intro-videos/' . $data->workout_intro_video);
    //         $this->deleteFileIfExists('program-exercise-input/' . $data->exercise_input_example);

    //         // Delete the database record
    //         $data->delete();

    //         return redirect()->route('form.index')->with('success', 'Record and associated files deleted successfully.');
    //     } else {
    //         return redirect()->route('form.index')->with('error', 'Record not found!');
    //     }
    // }

    // private function deleteFileIfExists($filePath)
    // {
    //     if (file_exists(public_path($filePath))) {
    //         File::delete(public_path($filePath));
    //     }
    // }

}
