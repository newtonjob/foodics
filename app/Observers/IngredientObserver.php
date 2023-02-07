<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Notifications\IngredientStockLow;
use Illuminate\Support\Facades\Notification;

class IngredientObserver
{
    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        if ($ingredient->wasChanged('stock') && $ingredient->shouldSendLowStockAlert()) {
            Notification::route('mail', 'merchant@foodics.com')->notify(
                new IngredientStockLow($ingredient)
            );
        }
    }
}
