<?php

namespace App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\Controller;
use App\Models\Set;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GymSetController extends Controller
{
    public function index(){

        $set = Set::latest()
        ->join('workouts', 'sets.workout_id', '=', 'workouts.id')
        ->select('sets.*', 'workouts.name as workout_name')
        ->paginate(5);
    

        return view('sets.index',compact('set'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $exercise=Exercise::all();
        $workout=Workout::all();
        return view('sets.create',compact('exercise','workout'));
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'set_type' => 'required',
            'no_of_time' => 'required',
            'inter_set_rest' => 'required',
            'intra_set_rest' => 'required',
            'estimated_duration' => 'required',
            'workout_id'=>'required',
            'exercises.*'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $input=$request->all();
        $input['exercises']=json_encode($request->exercises);
        
        
  
        Set::create($input);
     
        return redirect()->route('set.index')->with('success','Set created successfully.');
    }

    public function show($id)
    {
        $set = Set::find($id)
    ->join('workouts', 'workouts.id', 'workout_id')
    ->select('sets.*', 'workouts.name as workout_name')
    ->first();

        return view('sets.show',compact('set'));
    }

    public function edit($id)
    {
       $set=Set::find($id);
       $exercise=Exercise::all();
       $workout=workout::all();
        return view('sets.edit',compact('set','exercise','workout'));
    }   
    public function update(Request $request,$id)
    {
       
        $input= $request->all();
        $coach=Set::find($id);
        $coach->update($input);
    
        return redirect()->route('set.index')
                        ->with('success','Set updated successfully');
    }
    public function destroy($id)
    {
        $coach=Set::find($id);
        $coach->delete();
    
        return redirect()->route('set.index')
                        ->with('success','Set deleted successfully');
    }
}
