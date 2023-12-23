<?php

namespace App\Http\Controllers;
use App\Models\Coach;
use Illuminate\Http\Request;



class GymCoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $coachs = Coach::latest()->paginate(5);

        return view('coachs.index',compact('coachs'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('coachs.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|digits:11',
            'bio' => 'required'
        ]);
        
        
    
        Coach::create($request->all());
     
        return redirect()->route('coachs.index')->with('success','Coach created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Coach $coach)
    {
        return view('coachs.show',compact('coach'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Coach $coach)
    {
        return view('coachs.edit',compact('coach'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coach $coach)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|digits:11',
            'bio' => 'required'
        ]);
    
        $coach->update($request->all());
    
        return redirect()->route('coachs.index')
                        ->with('success','Coach updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coach $coach)
    {
        $coach->delete();
    
        return redirect()->route('coachs.index')
                        ->with('success','Coach deleted successfully');
    }
}
