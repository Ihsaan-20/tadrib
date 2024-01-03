<?php

// app/Http/Controllers/Api/Auth/LoginController.php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;







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

            // Create a new access token
            $tokenRes = $user->createToken('Personal Token Access');
            $token = $tokenRes->token;

            // Set token expiration time (e.g., 1 week)
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            // Update user status (if needed)
            // $status['user_status'] = 1;
            // $user->edit('id', $status, Auth::id());

            // Return the response with access token and user data
            return response()->json([
                'access_token' => $tokenRes->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
                'data' => Auth::user()
            ]);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
        $input['role'] = 'user';
        $input['role_id'] = 3;
        $input['password'] = Hash::make($input['password']);
        // $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        // Optionally, you can generate a token for the registered user
        $token = $user->createToken('User Registration Token')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201); // HTTP status code 201 indicates resource creation
    }

    public function sendForgetPasswordEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $userEmail = $request->input('email');
        $randomNumber = rand(1000, 9999);

        // Cache the random number for verification
        Cache::put('reset_password_' . $userEmail, $randomNumber, now()->addMinutes(10));

        // Send the email with the random number
        //  Mail::to($userEmail)->send(new ResetPasswordMail($randomNumber));
        $user = User::where('email',$request->input('email'))->first();

         return response()->json([
            'message' => 'Email sent successfully',
            'verification_code' => $randomNumber, // Include the random code in the response
            'data' => $user,
        ]);
    }
    public function verifyForgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|numeric',
            'new_password' => 'required', // Adjust the validation rules for the new password
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        $userEmail = $request->input('email');
        $verificationCode = $request->input('verification_code');
        $newPassword = $request->input('new_password');
    
        // Retrieve the stored verification code from the cache
        $storedVerificationCode = Cache::get('reset_password_' . $userEmail);
    
        if ($storedVerificationCode && $verificationCode == $storedVerificationCode) {
            // Verification successful
            // Update the user's password
            $user = User::where('email', $userEmail)->first();
            $user->update(['password' => Hash::make($newPassword)]);
    
            // Remove the verification code from the cache
            Cache::forget('reset_password_' . $userEmail);
    
            return response()->json(['message' => 'Password reset successful']);
        } else {
            return response()->json(['error' => 'Invalid verification code'], 401);
        }
    }



    public function getAllUsers()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ]);
    }









    public function show(User $user)
    {

        $user_id = Auth::user()->id;
        // dd($user_id);
        $data = User::find($user_id);
        return response()->json([
            'user' => $data,
        ], 200);
    } //method end here;


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
