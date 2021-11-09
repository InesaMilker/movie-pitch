<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store()
    {

        request()
            ->validate(['title' => 'required', 'content' => 'required', 'category_id' => 'required', ]);

        $isGuest = auth()->guest();

        if (!$isGuest)
        {
            $user_id = auth()->user()->id;

            if (Category::where('id', request('category_id'))
                ->exists())
            {
                return Post::create(['title' => request('title') , 'content' => request('content') , 'category_id' => request('category_id') , 'user_id' => $user_id, ]);
            }
            else
            {
                return response()->json(["message" => "Category not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }


    public function update(Request $request, $id)
    {
        if(Post::where('id', $id)->exists())
        {
            $isGuest = auth()->guest();
            if (!$isGuest)
            {

                $user_id = auth()->user()->id;
                $user_role = auth()->user()->role;

                if (Post::where('id', $id)->exists())
                {

                    $post = Post::find($id);

                    if ($user_id == $post->user_id || $user_role == 1)
                    {

                        $post->title = is_null($request->title) ? $post->title : $request->title;
                        $post->content = is_null($request->content) ? $post->content : $request->content;
                        // $post->category_id = is_null($request->category_id) ? $post->category_id : $request->category_id;
                        $post->category_id = $post->category_id;
                        $post->user_id = $post->user_id;
                        $post->save();

                        return response()
                            ->json(["message" => "Post updated successfully", "post" => $post], 200);
                    }
                    else
                    {
                        return response()->json(["message" => "Unauthorized"], 401);
                    }
                }
                else
                {
                    return response()
                        ->json(["message" => "Post not found"], 404);
                }
            }
            else
            {
                return response()
                    ->json(["message" => "Unauthorized"], 401);
            }

        }
        else{
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if (Post::where('id', $id)->exists())
            {

                $post = Post::find($id);

                //Checks if its current users post or its an admin trying to delete.
                if ($user_id == $post->user_id || $user_role == 1)
                {

                    $post->delete();

                    return response()
                        ->json(["message" => "post deleted"], 202);
                }

                else
                {
                    return response()
                        ->json(["message" => "Unauthorized"], 401);
                }

            }
            else
            {
                return response()
                    ->json(["message" => "post not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
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

    public function wantedPost($id, Comment $comments)
    {
        if(Post::where('id', $id)->exists())
        {
            $post = Post::where('id', $id)->get();
            return response((
                $comments = Comment::where('post_id', $id)->get()), 200);
        }
        else{
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }
}
