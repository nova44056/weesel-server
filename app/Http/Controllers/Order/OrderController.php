<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // abort_if(Gate::denies("order_create"), 403);
        if ($request->get("buyer_id")) {
            $this->validate($request, [
                'payment_method' => 'required|string',
                'products' => 'required|array|min:1',
            ]);
            $data = $request->only([
                'buyer_id'
            ]);
            $user = User::find($request->get("buyer_id"));
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['phone_number'] =
                $user->phone_number;
            $data['address_1'] = $user->address_1;
            $data['address_2'] = $user->address_2;
            $data['city'] = $user->city;
            $data['district'] = $user->district;
        } else {
            $this->validate($request, [
                'payment_method' => 'required|string',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone_number' => 'required|string',
                'address_1' => 'required|string',
                'address_2' => 'nullable|string',
                'city' => 'string|required',
                'district' => 'string|required',
                'products' => 'required|array|min:1',
            ]);
            $data = $request->only([
                'name',
                'email',
                'phone_number',
                'address_1',
                'city',
                'district',
                'payment_method'
            ]);
        }
        if ($request->get('aba_transaction_id')) {
            $data['aba_transaction_id'] = $request->get('aba_transaction_id');
        }

        $order = Order::create($data);
        $seller_ids = [];
        foreach ($request->get('products') as $product_id) {
            $product = Product::where('id', $product_id)->first();
            $order->products()->attach($product["id"], ['order_product_quantity' => $product["quantity"]]);
            array_push($seller_ids, $product["seller_id"]);
        }

        $seller_ids = array_unique($seller_ids);
        foreach ($seller_ids as $seller_id) {
            $order->sellers()->attach($seller_id);
        }

        return response()->json([
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
