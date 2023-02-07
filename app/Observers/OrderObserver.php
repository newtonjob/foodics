<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        dispatch(fn () => $order->products->each->sellout())->afterResponse();
    }
}
