<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('optimizeImages')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::with('children')->where('parent_id', '=', null)->get();
        if ($request->query('show') && $request->query('show') == 'parent_only')
            $categories = Category::where('parent_id', '=', null)->get();
        return response()->json([
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required|string|max:1000',
            'parent_id' => 'nullable|integer',
            'image' => 'file|nullable'
        ]);
        $image_path = $request->file('image')->store('category', 's3');
        Storage::disk('s3')->setVisibility($image_path, 'public');
        $category = Category::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'parent_id' => $request->get('id'),
            'image_url' => Storage::disk('s3')->url($image_path)
        ]);

        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'string|nullable',
            'description' => 'string|max:1000|nullable',
            'parent_id' => 'nullable|integer'
        ]);

        if ($request->has('name'))
            $category->name = $request->name;
        if ($request->has('description'))
            $category->description = $request->description;
        if ($request->has('parent_id'))
            $category->parent_id = $request->parent_id;

        if (!$category->isDirty())
            return response()->json([
                'error' => 'You need to specify a different value to update'
            ], 422);

        $category->save();
        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
