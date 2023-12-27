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

        return view('workout.index',compact('workout'))->with('i', (request()->input('page', 1) - 1) * 5);
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
        return view('workout.create',compact('tags','exercises'));
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
            'tags.*'=>'required',
            'number_of_exercises.*'=>'required',
        ]);
        


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $input=$request->all();
        $input['tags']=json_encode($request->tags);
        $input['number_of_exercises']=json_encode($request->number_of_exercises);
        $input['name']=$input['name'];

     

        if ($request->hasfile('introductory_video')) {

            $destination = 'public/introductory_video';
            $tags_profile = $request->file('introductory_video');
            $tagsprofile = uniqid() . $tags_profile->getClientOriginalName();
            $path = $tags_profile->storeAs($destination, $tagsprofile);

            $input['introductory_video'] = $tagsprofile;
        }


        
        $input['text_bio']=$input['text_bio'];
        $input['estimated_duration_hours']=$input['estimated_duration_hours'];
        $input['rest']=$input['rest'];
      
        
        
  
        Workout::create($input);
     
        return redirect()->route('workout.index')->with('success','Coach created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coach = User::find($id);
        return view('workout.show',compact('coach'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $tags = Tag::where('type', 'equipment')->get();

        $exercises=Exercise::all();
        $workout=Workout::find($id);
        return view('workout.edit',compact('tags','exercises','workout'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'bio' => 'required',
            'profile_picture'=>'image|mimes:jpeg,png,jpg,gif'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $input= $request->all();
        $coach=User::find($id);
     
        if ($request->hasfile('profile_picture')) {

            $image = rand(0000, 53453454) . '.' . $request->profile_picture->extension();
            $path = $request->profile_picture->storeAs('profile', $image, 'public');
            $input['profile_picture'] = $image;
        }
        $input['name']=$input['first_name'].' '.$input['last_name'];
        $coach->update($input);
    
        return redirect()->route('coachs.index')
                        ->with('success','Coach updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coach=User::find($id);
        $coach->delete();
    
        return redirect()->route('coachs.index')
                        ->with('success','Coach deleted successfully');
    }
}
