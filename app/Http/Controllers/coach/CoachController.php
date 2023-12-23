<?php

namespace App\Http\Controllers\coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CoachController extends Controller
{
    public function index()
    {
        return view('coach.index');
    }

    public function destroy(Request $request)
    {
       
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/coach/dashboard');
    }
}
