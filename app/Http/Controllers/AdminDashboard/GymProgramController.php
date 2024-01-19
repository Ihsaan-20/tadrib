<?php

namespace App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Tag;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;

class GymProgramController extends Controller
{
    public function index()
    {
        $perPage = 5;
        $programs = Program::latest()->simplePaginate($perPage);
    
        $pageNumber = request()->input('page', 1);
        $startIndex = ($pageNumber - 1) * $perPage;
    
        return view('programs.index', compact('programs', 'startIndex'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::all();
        $coach = User::where('role_id','=',2)->get();
        $workout = Workout::all();
        return view('programs.create', compact('tags','coach','workout'));
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

        // Syncing roles
     
        // Redirect to index or show view
        return redirect()->route('program.index')->with('success', 'Program created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tags = Tag::all();
        $coach = User::where('role_id','=',2)->get();
        $workout = Workout::all();
        $program=Program::find($id);
        return view('programs.edit', compact('tags','coach','workout','program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validation logic
        $request->validate([
            'name' => 'required',
            'description' => 'required',
          
           
            'text_bio' => 'required',
            'training_type' => 'required',
            'tag_equipment'=>'required',
           
            'duration_weeks'=>'required',
            'price_usd'=>'required',
            'level'=>'required',
            'number_of_workout'=>'required',
        ]);
$program=Program::find($id);
        // Updating logic
       $input=$request->all();
       if ($request->hasfile('introductory_video')) {
        $video=rand(000000,456423).'.'.$request->introductory_video->extension();
       $path=$request->introductory_video->storeAs('video',$video,'public');
       $input['introductory_video']=$path;
       }

       if ($request->hasfile('thumbnail')) {
        $image=rand(000000,456423).'.'.$request->thumbnail->extension();
        $path=$request->thumbnail->storeAs('video',$image,'public');
        $input['thumbnail']=$path; 
       }
       $input['training_type']=json_encode($request->training_type);
       $input['tag_equipment']=json_encode($request->tag_equipment);
       $input['number_of_workout']=json_encode($request->number_of_workout);

$program->update($input);
        //Syncing roles
      
        // Redirect to index or show view
        return redirect()->route('program.index')->with('success', 'program updated successfully.');
    }
    public function show($id)
    {
        $program = Program::find($id);
        return view('programs.show',compact('program'));
    } 
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
   public function destroy($id,Program $program)
{
    $program=Program::find($id);
    
    $program->delete();

    // Redirect to index or show view
    return redirect()->route('program.index')->with('success', 'Program deleted successfully.');
}
}