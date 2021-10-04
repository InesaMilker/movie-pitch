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
        request()->validate([
            'title' =>'required',
            'content' =>'required',
            'topic_id'=> 'required',
        ]);
        return Post::create([
            'title' => request('title'),
            'content' => request('content'),
            'topic_id'=> request('topic_id'),
        ]);
    }

    public function update(Post $post)
    {

    request()->validate([
        'title' =>'required',
        'content' =>'required',
        'topic_id' => 'required',
    ]);
    return $post->update([
        'title' => request('title'),
        'content' => request('content'),
        'topic_id' => request('topic_id'),
    ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(["message"=>"Successful clearence"], 200);
    }

    public function wanted($id)
    {
        return Post::find($id);
    }
}
