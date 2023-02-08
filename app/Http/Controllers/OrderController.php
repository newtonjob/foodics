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
            'products.*.product_id' => 'required|exists:products,id',
        ]);

        $order = tap($request->user()->orders()->create(),
            fn (Order $order) => $order->products()->attach($request->products)
        );

        return response(['message' => 'Order placed successfully', 'data' => compact('order')], 201);
    }
}
