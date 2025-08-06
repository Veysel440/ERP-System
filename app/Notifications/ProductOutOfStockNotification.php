<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProductOutOfStockNotification extends Notification
{
    use Queueable;

    public Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Stok Bitti: ' . $this->product->name)
            ->greeting('Sayın Yönetici,')
            ->line('Stokta olmayan ürün: ' . $this->product->name)
            ->line('Ürün Kodu: ' . $this->product->id)
            ->line('Mevcut stok: ' . $this->product->stock)
            ->action('Ürünü Görüntüle', url('/products/' . $this->product->id))
            ->line('Stokların güncellenmesi önerilir.');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'name'       => $this->product->name,
            'stock'      => $this->product->stock,
            'date'       => now(),
        ];
    }
}
