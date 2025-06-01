<?php

namespace App\Notifications\User;

// use Illuminate\Bus\Queueable;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use Illuminate\Notifications\Notification;

class DirectNotification extends Notification
{
    // use Queueable;

    private $title, $body, $fcmTokens;
    public function __construct($user, $created_notif)
    {
        $this->fcmTokens = $user->fcms->pluck('token')->toArray();
        $this->title = $created_notif->title;
        $this->body =  $created_notif->content;
    }

    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle($this->title)
            ->withBody($this->body)
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'route' => null,
        ];
    }
}
