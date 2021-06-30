<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Request $request)
    {
        $products = $category->products();
        if ($request->query("categories")) {
            $categoriesFilter = explode(",", $request->query("categories"));
            $products = $category->products()->whereHas('categories', function ($category) use ($categoriesFilter) {
                $category->whereIn('id', $categoriesFilter);
            });
        }

        if ($request->query("rating")) {
            $ratingFilter =
                $request->query("rating");
            $products = $products->where('rating', '>=', $ratingFilter);
        }

        if ($request->query('price')) {
            $priceFilter =
                explode(",", $request->query("price"));
            if (count($priceFilter) == 1) array_push($priceFilter, 4294967295);
            $products = $products->whereBetween('price', $priceFilter);
        }

        $limit = $request->query('limit');
        $products = $products->paginate($limit);

        return response()->json([
            'data' => $products
        ], 200);
    }
}
