<?php

namespace App\Observers;

trait HasObserver
{
    public static function bootHasObserver()
    {
        $observer = class_basename(static::class).'Observer';

        static::observe("App\Observers\\$observer");
    }
}
