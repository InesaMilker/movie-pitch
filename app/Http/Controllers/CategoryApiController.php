<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    public function index()
    {
        return Category::all();
    }
    public function test()
    {

        $isGuest = auth()->guest();

        if (!$isGuest)
        {
            $user = auth()->user();
            $user_role = auth()->user()->role;
            return response()
                ->json($user, 200);
        }
        else
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
    }

    public function store()
    {
        request()
            ->validate(['title' => 'required', ]);

        $isGuest = auth()->guest();

        if (!$isGuest)
        {
            $user_id = auth()->user()->id;

            return Category::create(['title' => request('title') , 'user_id' => $user_id, ]);
        }
        else
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
    }

    public function update(Request $request, $id){

        $isGuest = auth()->guest();

        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if (Category::where('id', $id)->exists())
            {

                $category = Category::find($id);

                if ($user_id == $category->user_id || $user_role == 1)
                {

                    $category->title = is_null($request->title) ? $category->title : $request->title;
                    $category->user_id = $category->user_id;
                    $category->save();

                    return response()
                        ->json(["message" => "category updated successfully"], 200);
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
                    ->json(["message" => "category not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function destroy($id)
    {
        $isGuest = auth()->guest();

        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if (Category::where('id', $id)->exists())
            {

                $category = Category::find($id);
                if ($user_id == $category->user_id || $user_role == 1)
                {
                    $category->delete();

                    return response()
                        ->json(["message" => "category deleted"], 202);
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
                    ->json(["message" => "category not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function wanted($id, Post $post)
    {
        if(Category::where('id', $id)->exists())
        {
            return Category::find($id);
        }
        else{
            return response()->json([
                "message" => "category not found"
            ], 404);
        }
    }

    public function wanted_post($id, Post $post)
    {
        if(Category::where('id', $id)->exists()){
            $category = Category::where('id', $id)->get();
            return response((
                $post = Post::where('category_id', $id)->get()), 200);
            } else {
                return response()->json([
                    "message" => "Post not found"
                ], 404);
            }
    }
}
