<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiClientController extends Controller
{
    public function get_user_id($id){
        $user=User::find($id);
        if($user){
            return response()->json([
                'status' => 200,
                'message' => $user->role.' record is available!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'record not found!',
            ], 404);
        }
    }


    public function edit_user_id(Request $request,$id){
        $user=User::find($id);
        if($user){
if($request->first_name){
    $user->first_name=$request->first_name;
}
if($request->last_name){
    $user->last_name=$request->last_name;
}
if($request->email){
    $user->email=$request->email;
}
if($request->password){
    $user->password=$request->password;
}
if ($request->hasfile('profile_picture')) {

    $image = rand(0000, 53453454) . '.' . $request->profile_picture->extension();
    $path = $request->profile_picture->storeAs('profile', $image, 'public');
    $user->profile_picture = $path;
}else if($request->filled('profile_picture')){
    $user->profile_picture =$request->profile_picture;
}

$user->name=$user->first_name.' '.$user->last_name;
$user->save();

            return response()->json([
                'status' => 200,
                'message' => $user->role.' record is updated!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'record not found!',
            ], 404);
        }
    }
}
