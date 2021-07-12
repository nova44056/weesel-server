<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        if ($request->query('parent_id')) {
            $categories = Category::where('parent_id', '=', $request->query('parent_id'));
        } else {
            $categories = Category::where('parent_id', '=', null);
        }
        if ($request->query('include') && $request->query('include') == 'children')
            $categories = $categories->with('children');
        $categories = $categories->get();
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
        abort_if(Gate::denies("category_create"), 403, "Unauthorized");
        $this->validate($request, [
            'name' => 'required',
            'parent_id' => 'nullable|integer',
            'image' => 'file|nullable'
        ]);
        if ($request->image) {
            $image_path = $request->file('image')->store('category', 's3');
            Storage::disk('s3')->setVisibility($image_path, 'public');
        }
        $category = Category::create([
            'name' => $request->get('name'),
            'parent_id' => $request->get('parent_id'),
            'image_url' => $request->image ? Storage::disk('s3')->url($image_path) : null
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
        $category['children'] = $category->children()->get();
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
        abort_if(Gate::denies("category_update"), 403, "Unauthorized");
        $this->validate($request, [
            'name' => 'string|nullable',
            'parent_id' => 'nullable|integer'
        ]);

        if ($request->has('name'))
            $category->name = $request->name;
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
        abort_if(Gate::denies("category_delete"), 403, "Unauthorized");
        // check if the parent_id of category is null or not
        // delete all category children if it has a parent_id of null
        if (!$category->parent_id) {
            Category::where('parent_id', '=', $category->id)->delete();
        }
        $category->products()->delete();
        // delete category
        $category->delete();
        return response()->json([
            'message' => 'Deleted successfully.',
            'data' => $category
        ], 200);
    }
}
