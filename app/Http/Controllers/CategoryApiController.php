<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{public function index()
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

    public function update(Category $categories)
    {

    request()->validate([
        'title' =>'required',

    ]);
    return $categories->update([
        'title' => request('title'),

    ]);
    }

    public function destroy(Category $categories)
    {
        $categories->delete();
        return response()->json(["message"=>"Successful clearence"], 200);
    }

    public function wanted($id)
    {
        return Category::find($id);
    }
}
