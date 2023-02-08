<?php

namespace App\Models\Traits;

use App\Notifications\IngredientStockLow;
use Illuminate\Support\Facades\Notification;

trait InteractsWithIngredientStock
{
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

    /**
     * Send a low stock notification to the merchant.
     */
    public function sendLowStockAlert()
    {
        Notification::route('mail', 'merchant@foodics.com')
            ->notify(new IngredientStockLow($this));

        $this->update(['low_stock_alert_sent_at' => now()]);
    }
}
