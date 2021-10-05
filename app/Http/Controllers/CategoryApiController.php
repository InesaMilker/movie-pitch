<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
class CategoryApiController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store()
    {
        request()->validate([
            'title' =>'required',

        ]);
        return Category::create([
            'title' => request('title'),

        ]);
    }

    public function update(Request $request, $id){

        if (Category::where('id', $id)->exists()) {
            $category = Category::find($id);
            $category->title = is_null($request->title) ? $category->title : $request->title;
            $category->save();

            return response()->json([
                "message" => "category updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "category not found"
            ], 404);

        }
    }

    public function destroy($id)
    {
        if(Category::where('id', $id)->exists())
        {
            $category = Category::find($id);
            $category->delete();
            return response()->json(["message"=>"Successful clearence"], 200);
        }
        else{
            return response()->json([
                "message" => "category not found"
            ], 404);
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
                $post = Post::where('categories_id', $id)->get()), 200);
            } else {
                return response()->json([
                    "message" => "Post not found"
                ], 404);
            }
    }
}
