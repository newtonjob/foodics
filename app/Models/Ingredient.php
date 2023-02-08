<?php

namespace App\Models;

use App\Models\Traits\InteractsWithIngredientStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory, InteractsWithIngredientStock;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted()
    {
        static::updated(function (Ingredient $ingredient) {
            if ($ingredient->wasChanged('stock') && $ingredient->shouldSendLowStockAlert()) {
                $ingredient->sendLowStockAlert();
            }
        });
    }
}
