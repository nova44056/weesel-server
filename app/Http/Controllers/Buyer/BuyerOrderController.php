<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        abort_if($request->user()->id !== $buyer->id, 403, "Unauthorized");
        $orders = $buyer->orders()->get();
        return response()->json([
            'data' => $orders
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer, $orderID)
    {
        abort_if($request->user()->id !== $buyer->id, 403, "Unauthorized");
        $order = $buyer->orders()->where('id', '=', $orderID)->get();
        return response()->json([
            'data' => $order
        ]);
    }
}
