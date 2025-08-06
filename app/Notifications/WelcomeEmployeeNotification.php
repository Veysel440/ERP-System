<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeEmployeeNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ekibe Hoş Geldiniz!')
            ->greeting('Merhaba ' . $notifiable->name . ' 👋')
            ->line('Kurumsal ERP sistemimize hoş geldiniz. Artık sisteme giriş yapabilirsiniz.')
            ->action('Giriş Yap', url('/login'))
            ->line('Başarılar dileriz!');
    }
}
