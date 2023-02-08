<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Perform any actions required after the model boots.
     */
    protected static function booted()
    {
        static::created(function (Order $order) {
            dispatch(fn () => $order->products->each->sellout())->afterResponse();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)
            ->withPivot(['price', 'quantity'])
            ->withTimestamps();
    }
}
