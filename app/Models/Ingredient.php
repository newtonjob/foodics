<?php

namespace App\Models;

use App\Models\Traits\InteractsWithIngredientStock;
use App\Observers\HasObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory, HasObserver, InteractsWithIngredientStock;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];
}
