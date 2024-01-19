<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Exercise;

use App\Models\User;

class ExercisesController extends Controller
{
    public function index()
    {
        $perPage = 5;
        $exercise = Exercise::latest()->simplePaginate($perPage);
    
        $pageNumber = request()->input('page', 1);
        $startIndex = ($pageNumber - 1) * $perPage;
    
        return view('exercise.index', compact('exercise', 'startIndex'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
             $coach = User::where('role_id','=',2)->get();
        return view('exercise.create', compact('coach'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation logic
        $request->validate([
            'name' => 'required',
            'text_bio' => 'required',
            'coach_id'=>'required',
            'repetitions' => 'required|integer',
            'video' => 'required|mimes:mp4,avi,mov,wmv|max:10240', // Adjust the allowed video file types and size
        ]);
    
        // Saving logic
        $videoPath = null;
    
        if ($request->hasFile('video')) {
            $destination = 'public/exercise_videos';
            $videoFile = $request->file('video');
            $videoFileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();
            $videoPath = $videoFile->storeAs($destination, $videoFileName);
        }
    



        
        Exercise::create([
            'name' => $request->input('name'),
            'description_video' => $videoFileName,
            'text_bio' => $request->input('text_bio'),
             'coach_id' => $request->input('coach_id'),
            'repetitions' => $request->input('repetitions'),
        ]);
    
        // Redirect to index or show view
        return redirect()->route('exercises.index')->with('success', 'Exercise created successfully.');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Exercise $exercises)
    {

 $coach = User::where('role_id','=',2)->get();
        $exercise = Exercise::find($exercises->id);
        return view('exercise.edit', compact('exercise','coach'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Exercise $exercises)
    {
     

      // Validation logic
    $request->validate([
        'name' => 'required',
        'text_bio' => 'required',
        'repetitions' => 'required|integer',
        'video' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240', // Adjust the allowed video file types and size
    ]);

    // Fetch the Exercise by ID
    $exercise = Exercise::find($exercises->id);

    // Check if the exercise is found
    if ($exercise) {
        // Saving logic
        $exerciseData = [
            'name' => $request->input('name'),
            'text_bio' => $request->input('text_bio'),
              'coach_id' => $request->input('coach_id'),
            'repetitions' => $request->input('repetitions'),
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

        // Redirect to index or show view
        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
    } else {
        // Handle case when the exercise is not found
        return redirect()->route('exercises.index')->with('error', 'Exercise not found.');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Exercise $exercises)
    {
        $exercises->delete();
        
        // Redirect to index or show view
        return redirect()->route('exercises.index')->with('success', 'exercises deleted successfully.');
    }
}
