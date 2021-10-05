<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store()
    {
        return Post::create([
            'title' => request('title'),
            'content' => request('content'),
            'categories_id'=> request('categories_id'),
        ]);
    }

    public function update($id)
    {
        if(Post::where('id', $id)->exists())
        {
            request()->validate([
            'title' =>'required',
            'content' =>'required',
            'categories_id' => 'required',
            ]);
            $post = Post::find($id);
            return $post->update([
            'title' => request('title'),
            'content' => request('content'),
            'categories_id' => request('categories_id'),
            ]);
        }
        else{
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        if(Post::where('id', $id)->exists())
        {
            $post = Post::find($id);
            $post->delete();
            return response()->json(["message"=>"Successful clearence"], 200);
        }
        else{
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }

    public function wanted($id)
    {
        if(Post::where('id', $id)->exists())
        {
            return Post::find($id);
        }
        else{
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }
}
