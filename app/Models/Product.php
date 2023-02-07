<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'low_stock_alert_sent_at' => 'datetime'
    ];

    /**
     * Sellout from the product's ingredient stock, the quantity that was ordered.
     */
    public function sellout(): void
    {
        $quantity = $this->pivot->quantity ?? 1;

        $this->ingredients->each(
            fn ($ingredient) => $ingredient->decrement('stock', $ingredient->pivot->quantity * $quantity)
        );
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withTimestamps();
    }
}
