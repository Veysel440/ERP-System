<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'slack', 'nexmo'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Yeni Görev Atandı')
            ->greeting('Merhaba, ' . $notifiable->name)
            ->line('Size yeni bir görev atandı: ' . $this->task->title)
            ->action('Görev Detayına Git', url('/tasks/' . $this->task->id))
            ->line('Başarılar!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id'   => $this->task->id,
            'title'     => $this->task->title,
            'assigned_at' => now(),
            'message'   => 'Yeni görev atandı: ' . $this->task->title,
        ];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->success()
            ->content('Yeni görev atandı: ' . $this->task->title)
            ->attachment(function ($attachment) {
                $attachment->title('Görev Detayı', url('/tasks/' . $this->task->id))
                    ->fields([
                        'Proje'   => $this->task->project?->name,
                        'Atayan'  => auth()->user()?->name ?? 'Sistem',
                    ]);
            });
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Yeni görev atandı: ' . $this->task->title . ' - ERP Sistemi');
    }
}
