<?php

namespace App\Listeners;


use App\Events\ProductOutOfStock;
use App\Models\User;
use App\Notifications\ProductOutOfStockNotification;

class NotifyAdminsProductOutOfStock
{
    public function handle(ProductOutOfStock $event)
    {
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ProductOutOfStockNotification($event->product));
        }
    }
}
