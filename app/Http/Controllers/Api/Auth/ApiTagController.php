<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class ApiTagController extends Controller
{
    public function get_all_tags(){
        $tag=Tag::all();
        return response()->json([
            'status' => 200,
            'message' => 'Data fetched',
            'Coachs' =>  $tag
        ], 200);
    }


    public function get_tag_id($id){
$tag=Tag::find($id);
if($tag){
    return response()->json([
        'status' => 200,
        'message' => 'Data fetched',
        'Coachs' =>  $tag
    ], 200);
}else{
    return response()->json([
        'status' => 404,
        'message' => 'No data found...',
    ], 404);
}
    }



    public function store_tags(Request $request){
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

        if($tags)
        {
            return response()->json([
                'status' => 200,
                'message' => 'tags added successfully!',
                'data'=>$tags
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


    public function edit_tags(Request $request,$id){
        $request->validate([
            'tag' => 'required',
            'type' => 'required',
           
        ]);
    
        $tags = Tag::find($id); // Use $request->input('id') instead of $request->id
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
        if($tags)
        {
            return response()->json([
                'status' => 200,
                'message' => 'tags updated successfully!',
                'data'=>$tags
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'not found!',
            ], 404);
        }
    }

    public function delete_tag($id){
        $tags = Tag::find($id);
        $tags->delete();
        if($tags)
        {
            return response()->json([
                'status' => 200,
                'message' => 'tags deleted successfully!',
                'data'=>$tags
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'message' => 'not found!',
            ], 404);
        }
    }
}
