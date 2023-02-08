<?php

namespace App\Models;

use App\Observers\HasObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, HasObserver;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class)
            ->withPivot(['price', 'quantity'])
            ->withTimestamps();
    }
}
