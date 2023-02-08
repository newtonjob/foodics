<?php

namespace App\Observers;

use App\Models\Ingredient;

class IngredientObserver
{
    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        if ($ingredient->wasChanged('stock') && $ingredient->shouldSendLowStockAlert()) {
            $ingredient->sendLowStockAlert();
        }
    }
}
