<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class GymCoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $coachs = User::where('role_id',2)->latest()->paginate(5);

        return view('coachs.index',compact('coachs'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags=Tag::all();
        return view('coachs.create',compact('tags'));
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
            'first_name' => 'required',
            'last_name' => 'required',
             'email' => 'required|email|unique:users,email',
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
        
  
        User::create($input);
     
        return redirect()->route('coachs.index')->with('success','Coach created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coach = User::find($id);
        return view('coachs.show',compact('coach'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $tags=Tag::all();
       $coach=User::find($id);
        return view('coachs.edit',compact('coach','tags'));
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
            'email' => 'required|email|unique:users,email',
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
