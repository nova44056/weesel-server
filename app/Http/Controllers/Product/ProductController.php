<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('images')->get();
        return response()->json([
            'data' => $products
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
            'name' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'seller_id' => 'required|integer',
            'status' => Rule::in(Product::$productStatus),
            'category_ids' => 'required|array|min:1',
            // 'images' => 'array|file|nullable'
        ]);
        $data = $request->only([
            'name',
            'description',
            'quantity',
            'seller_id',
            'status'
        ]);
        if (request()->get('discount')) $data['discount'] = $request->get('discount');
        $newProduct = Product::create($data);
        $newProduct->categories()->attach($request->get('category_ids'));
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $image_path = $image->store('images', 's3');
                Storage::disk('s3')->setVisibility($image_path, 'public');
                ProductImage::create([
                    'product_id' => $newProduct->id,
                    'image_url' => Storage::disk('s3')->url($image_path)
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
            'data' => $product
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
        $product->delete();
        return response()->json([
            'data' => $product,
            'success' => 'Product has been deleted successfully'
        ], 200);
    }
}
