<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Tag;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCoachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCoachPrograms(int $coach_id)
    {
        // dd($coach_id);

        $programs = Program::where('coach_id', $coach_id)->get();
        if($programs)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'programs' => $programs
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'No data found...',
            ], 404);
        }
    }


    public function getAllCoachs(Request $request)
    {
        $keyword = $request->input('search');

        $query = User::query();

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('phone_number', 'like', "%$keyword%")
                ->orWhere('bio', 'like', "%$keyword%");
        }

        $coachs = $query->latest()->get();
        $train=[];
        if ($coachs->isNotEmpty()) {
            foreach($coachs as $c){
              
                $training=json_decode($c->tags);
                if($training != null){
                    foreach($training as $t){
                        $tag=Tag::find($t);
                      
                        $train[]=$tag->tag;
                    }
                   
                    $c['tags']=$train;
                }else{
                    $c['tags']=null;
                }
               
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data fetched',
                'Coachs' => $coachs
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
    public function storeNewCoach(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'bio' => 'required',
            'tags.*'=>'required',
            'password'=>'required|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $input=$request->all();
        $input['tags']=json_encode($request->tags);
        $input['name']=$input['first_name'].' '.$input['last_name'];
        $input['role']='coach';
        $input['role_id']=2;
        
  
        $Coachs=User::create($input);

            if($Coachs)
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Coach added successfully!',
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
    public function showCoach($id)
    {
        $coachs = User::find($id);

        if ($coachs) {
            $training=json_decode($coachs->tags);
            if($training != null){
                foreach($training as $t){
                    $tag=Tag::find($t);
                  
                    $train[]=$tag->tag;
                }
               
                $coachs['tags']=$train;
            }else{
                $coachs['tags']=null;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Coach record is available!',
                'coach' => $coachs
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Coach record not found!',
            ], 404);
        }
    }


      /**
     * Edit the specified resource in storage.
     */
    public function editCoachData($id)
    {
        $coach = Coach::find($id);

        if($coach)
        {
            return response()->json([
                'status' => 200,
                'message' => 'coach record is available!',
                'coach' => $coach
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'coach record not found!',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCoachData(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'bio' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
     
        $input= $request->all();
       
        $Coach = User::find($id);
      
        
        if ($request->hasfile('profile_picture')) {

            $image = rand(0000, 53453454) . '.' . $request->profile_picture->extension();
            $path = $request->profile_picture->storeAs('profile', $image, 'public');
            $input['profile_picture'] = $path;
        }else if($request->filled('profile_picture')){
            $input['profile_picture'] =$request->profile_picture;
        }
        if($request->tags){
            $input['tags'] = json_encode($request->tags);
        }
        $input['name']=$input['first_name'].' '.$input['last_name'];
        
        
        if($Coach){
        $Coach->update($input);
        return response()->json([
            'status' => 200,
            'message' => 'Coach updated successfully!',
        ], 200);
    }
    else
    {
        return response()->json([
            'status' => 404,
            'message' => 'Coach record not found!',
        ], 404);
    }
        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCoach($id)
    {
        $coach = Coach::find($id);

        if($coach)
        {
            $coach->delete();
            return response()->json([
                'status' => 200,
                'message' => 'coach deleted successfully!',
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'coach record not found!',
            ], 404);
        }
    }
}
