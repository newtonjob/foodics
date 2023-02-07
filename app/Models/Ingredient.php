<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Determine if the ingredient stock is low and a low stock notification should be sent.
     */
    public function shouldSendLowStockAlert(): bool
    {
        if ($this->lowStockAlertHasBeenPreviouslySent()) {
            return false;
        }

        return $this->stock <= $this->low_stock_threshold;
    }

    /**
     * Determine if a low stock notification has been previously sent for this ingredient.
     */
    public function lowStockAlertHasBeenPreviouslySent(): bool
    {
        return (bool) $this->low_stock_alert_sent_at;
    }
}
