<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products'              => 'required|array',
            'products.*.product_id' => 'required',
        ]);

        $order = tap(Order::create(['user_id' => $request->user()->id]), function (Order $order) use ($request) {
            $order->products()->attach(
                $request->collect('products')->keyBy->product_id->map->only('quantity')
            );
        });

        return response(['message' => 'Order placed successfully', 'data' => compact('order')], 201);
    }
}
