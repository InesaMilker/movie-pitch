<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentApiController extends Controller
{
    public function index()
    {
        return Comment::all();
    }

    public function store()
    {
        request()->validate([
            'author_name' =>'required',
            'comment_text' =>'required',
            'post_id'=> 'required',
        ]);
        return Comment::create([
            'author_name' => request('author_name'),
            'comment_text' => request('comment_text'),
            'post_id'=> request('post_id'),
        ]);
    }

    public function update(Comment $comment)
    {

    request()->validate([
        'author_name' =>'required',
        'comment_text' =>'required',
        'post_id' => 'required',
    ]);
    return $comment->update([
        'author_name' => request('author_name'),
        'comment_text' => request('comment_text'),
        'post_id' => request('post_id'),
    ]);
    }

    public function destroy($id)
    {
        if(Comment::where('id', $id)->exists())
        {
            $comment = Comment::find($id);
            $comment->delete();
            return response()->json(["message"=>"Successful clearence"], 200);
        }
        else{
            return response()->json([
                "message" => "comment not found"
            ], 404);
        }
    }

    public function wanted($id)
    {
        if(Comment::where('id', $id)->exists())
        {
            return Comment::find($id);
        }
        else{
            return response()->json([
                "message" => "Comment not found"
            ], 404);
        }
    }
}
