<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {


        $tags = Tag::latest()->paginate(5);

        return view('tags.index', compact('tags'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        //return view('Tags.create');
        return view('tags.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    //     // Validate the form data
    //     $request->validate([
    //         'tags' => 'required|array',
    //         'tags.*' => 'exists:tags,id', // Assuming your tags are stored in a 'tags' table
    //     ]);

    //    dd($request->all());
    // foreach ($request->input('tags') as $tagId) {

    //     $tag = Tag::find($tagId) ?? new Tag(['id' => $tagId]);
    //     $tag->save();
    // }
    //     return redirect()->route('tags.index')
    //                     ->with('success','Tag created successfully.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'required',
            'type' => 'required',
            'image' => 'required',
        ]);

        $tags = new Tag;
        $tags->tag = $request->tag;
        $tags->type = $request->type;

        if ($request->hasfile('image')) {

            $destination = 'public/tags/profile';
            $tags_profile = $request->file('image');
            $tagsprofile = uniqid() . $tags_profile->getClientOriginalName();
            $path = $tags_profile->storeAs($destination, $tagsprofile);

            $tags->photo = $tagsprofile;
        }
        $tags->save();


        // Tag::create($request->all());
        return redirect()->route('tags.index')->with('success', 'Tags created/updated successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag' => 'required',
            'type' => 'required',
           
        ]);
    
        $tags = Tag::find($tag->id); // Use $request->input('id') instead of $request->id
        $tags->tag = $request->tag;
        $tags->type = $request->type;
    
        if ($request->hasfile('image')) {
            $destination = 'public/tags/profile';
            $tags_profile = $request->file('image');
            $tagsprofile = uniqid() . $tags_profile->getClientOriginalName();
            $path = $tags_profile->storeAs($destination, $tagsprofile);
    
            $tags->photo = $tagsprofile;
        }
        $tags->save();

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully');
    }
}
