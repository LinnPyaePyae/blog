<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;

                $builder->where("title", "LIKE", "%" . $keyword . "%");
            });
        })
            ->when(request()->has('id'), function ($query) {
                $sortType = request()->id ?? 'asc';
                $query->orderBy("id", $sortType);
            })
            ->latest("id")
            ->paginate(10)->withQueryString();
        $data = CategoryResource::collection($categories);
        return response()->json([
            "categories" => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // $this->authorize('create',App\Models\Category::class);
        $category = Category::create([
            "title" => $request->title,
            "user_id" => Auth::id()
        ]);
        return response()->json([
            "message" => "$category[title] is created"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                "message" => "category not found"
            ], 404);
        }

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request,$id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                "message" => "Category not found"
            ], 404);
        }


        if ($request->has('title')) {
            $category->title = $request->title;
        }


        $category->update();

        return response()->json([
            "message" => "Category title $category[title] is updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response()->json([
                "message" => "Category not found"
            ], 404);
        }
        $category->delete();
        return response()->json([
            "message" => "$category[title] is deleted"
        ], 200);
    }
}
