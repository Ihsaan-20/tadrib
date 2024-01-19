<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GymClientController extends Controller
{
    public function index()
    {

        $coachs = User::where('role_id',3)->latest()->paginate(5);

        return view('user.index',compact('coachs'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
             'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'password'=>'required|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $input=$request->all();
        $input['name']=$input['first_name'].' '.$input['last_name'];
        $input['role']='user';
        $input['role_id']=3;
        
  
        User::create($input);
     
        return redirect()->route('user.index')->with('success','User created successfully.');
    }

    public function show($id)
    {
        $coach = User::find($id);
        return view('user.show',compact('coach'));
    } 
     


    public function edit($id)
    {
       $coach=User::find($id);
        return view('user.edit',compact('coach'));
    }
    

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
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
    
        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        $coach=User::find($id);
        $coach->delete();
    
        return redirect()->route('user.index')
                        ->with('success','User deleted successfully');
    }
}
