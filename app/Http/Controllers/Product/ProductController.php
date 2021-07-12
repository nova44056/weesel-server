<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $products = Product::with('images');
        if ($request->query('name')) {
            $products = $products->where('name', 'LIKE', '%' . $request->query('name') . '%');
        }
        if ($request->query('category') && $request->query('category') != 'all') {
            $products = $products->where('category', '=', $request->query('category'));
        }
        return response()->json([
            'data' => $products->get()
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
        abort_if(Gate::denies("product_create"), 403, "Unauthorized");

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|float',
            'rating' => 'required|integer',
            'status' => Rule::in(Product::$productStatus),
            'category_ids' => 'required|array|min:1',
        ]);
        $data = $request->only([
            'name',
            'description',
            'rating',
            'price',
            'quantity',
            'status'
        ]);
        if (request()->get('discount')) $data['discount'] = $request->get('discount');
        $data['seller_id'] = auth()->user()->id;
        $newProduct = Product::create($data);
        $newProduct->categories()->attach($request->get('category_ids'));
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $image_path = $image->store('images', 's3');
                Storage::disk('s3')->setVisibility($image_path, 'public');
                ProductImage::create([
                    'product_id' => $newProduct->id,
                    'url' => Storage::disk('s3')->url($image_path)
                ]);
            }
        }
        return response()->json([
            'data' => $newProduct
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return response()->json([
            'data' => $product->with('images')->with('categories:id,name')->where('id', '=', $product->id)->get()->first()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        abort_if(Gate::denies("product_delete"), 403, "Unauthorized");
        $product->categories()->detach();
        $product->delete();
        return response()->json([
            'success' => 'Product has been deleted successfully',
            'data' => $product
        ], 200);
    }
}
