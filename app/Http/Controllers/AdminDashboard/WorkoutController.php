<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\User;
use App\Models\Tag;
use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Facades\Validator;

class WorkoutController extends Controller
{
    public function index()
    {

        $workout = Workout::latest()->paginate(5);

        return view('workout.index', compact('workout'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::where('type', 'equipment')->get();
        $exercises = Exercise::all();
        $coach = User::where('role_id','=',2)->get();
        return view('workout.create', compact('tags', 'exercises','coach'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'introductory_video' => 'required', // Adjust the allowed video file types and size
            'text_bio' => 'required',
            'estimated_duration_hours' => 'required',
            'rest' => 'required',
            'coach_id'=>'required',
            'tags' => 'required',
            'number_of_exercises' => 'required',
        ]);



        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();
        $input['tags'] = json_encode($request->tags);
        $input['number_of_exercises'] = json_encode($request->number_of_exercises);
        $input['name'] = $input['name'];



        if ($request->hasfile('introductory_video')) {

            $destination = 'public/introductory_video';
            $tags_profile = $request->file('introductory_video');
            $tagsprofile = uniqid() . $tags_profile->getClientOriginalName();
            $path = $tags_profile->storeAs($destination, $tagsprofile);

            $input['introductory_video'] = $tagsprofile;
        }







        $input['text_bio'] = $input['text_bio'];
        $input['estimated_duration_hours'] = $input['estimated_duration_hours'];
        $input['rest'] = $input['rest'];




        Workout::create($input);

        return redirect()->route('workout.index')->with('success', 'Coach created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workout = Workout::find($id);




        return view('workout.show', compact('workout'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $tags = Tag::where('type', 'equipment')->get();
        $coach = User::where('role_id','=',2)->get();
        $exercises = Exercise::all();
        $workout = Workout::find($id);
        return view('workout.edit', compact('tags', 'exercises', 'workout','coach'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'introductory_video' => 'required', // Adjust the allowed video file types and size
            'text_bio' => 'required',
            'estimated_duration_hours' => 'required',
            'rest' => 'required',
             'coach_id'=>'required',
            'tags.*' => 'required',
            'number_of_exercises.*' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $workout = Workout::findOrFail($id); // Assuming you have a Workout model

        $input = $request->all();
        $input['tags'] = json_encode($request->tags);
        $input['number_of_exercises'] = json_encode($request->number_of_exercises);
        $input['name'] = $input['name'];

        if ($request->hasfile('introductory_video')) {

            $destination = 'public/introductory_video';
            $tags_profile = $request->file('introductory_video');
            $tagsprofile = uniqid() . $tags_profile->getClientOriginalName();
            $path = $tags_profile->storeAs($destination, $tagsprofile);

            $input['introductory_video'] = $tagsprofile;
        }


        $input['text_bio'] = $input['text_bio'];
        $input['estimated_duration_hours'] = $input['estimated_duration_hours'];
        $input['rest'] = $input['rest'];

        $workout->update($input);

        return redirect()->route('workout.index')->with('success', 'Workout updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
  public function destroy($id)
    {
      
        $workout = Workout::find($id);
        $workout->delete();

        return redirect()->route('coachs.index')
            ->with('success', 'Coach deleted successfully');
    }
}
