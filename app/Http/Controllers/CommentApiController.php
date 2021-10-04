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

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(["message"=>"Successful clearence"], 200);
    }

    public function wanted($id)
    {
        return Comment::find($id);
    }
}
