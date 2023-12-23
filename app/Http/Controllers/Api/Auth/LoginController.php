<?php

// app/Http/Controllers/Api/Auth/LoginController.php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;




class LoginController extends Controller
{
   
    public function login(Request $request)
    {
        // Validation rules
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        // Validation
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Validation passed, attempt authentication
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }//method end here;

    public function show(User $user)
    {

        $user_id = Auth::user()->id;
        // dd($user_id);
        $data = User::find($user_id);
        return response()->json([
            'user' => $data,
        ], 200);
    }//method end here;


    public function destroy()
    {
        $user = Auth::user();
        // Revoke the user's access tokens
        $user->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully'], 200);
    }//method end here;
}
