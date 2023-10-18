<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\BlogResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\VarDumper\VarDumper;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where("title", "LIKE", "%" . $keyword . "%");
                $builder->orWhere("content", "LIKE", "%" . $keyword . "%");
            });
        })
            ->when(request()->has('id'), function ($query) {
                $sortType = request()->id ?? 'asc';
                $query->orderBy("id", $sortType);
            })
            ->latest("id")
            ->paginate(10)->withQueryString();
        $data = BlogResource::collection($blogs);
        return response()->json([
            "blog" => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        // $this->authorize('create',App\Models\Blog::class);
        $blog = Blog::create([
            "title" => $request->title,
            "content" => $request->content,
            "category_id" => $request->category_id,
            "user_id" => Auth::id()
        ]);
        return response()->json([
            "message" => "$blog[title] is created"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return response()->json([
                "message" => "Blog not found"
            ], 404);
        }

        return new BlogDetailResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request,$id)
    {
        try{
            $blog =Blog::findOrFail($id);


            if ($request->has('title')) {
                $blog->title = $request->title;
            }

            if ($request->has('content')) {
                $blog->content = $request->content;
            }

            $blog->update();

            return response()->json([
                "message" => "Blog $blog[title] is updated"
            ], 200);
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "message" => "Blog not found"
            ], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // $this->authorize("delete", $blog);

            $blog->delete();

            return response()->json([
                "message" => "Blog '{$blog->title}' is deleted"
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "message" => "Blog not found"
            ], 404);
        }
    }
}
