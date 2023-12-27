<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Tag;
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
        return view('programs.create', compact('tags'));
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
            'progress' => 'required',
            'tags' => 'required|array',
        ]);

        // Saving logic
        $program = Program::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'progress' => $request->input('progress') ,
        ]);

        // Syncing roles
        $program->tags()->sync($request->input('tags'));

        // Redirect to index or show view
        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(Program $program)
    {
        $tags = Tag::all();
        return view('programs.edit', compact('program', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Program $program)
    {
        // Validation logic
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'progress' => 'required',
            'tags' => 'required|array',
        ]);

        // Updating logic
        $program->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'progress' => $request->input('progress'),
        ]);

        //Syncing roles
        $program->tags()->sync($request->input('tags'));

        // Redirect to index or show view
        return redirect()->route('programs.index')->with('success', 'program updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Program $program)
    {
        $program->delete();
        
        // Redirect to index or show view
        return redirect()->route('programs.index')->with('success', 'Program deleted successfully.');
    }
}