<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendTripPublishedNotif extends Notification
{
    use Queueable;
    private  $title, $body, $life_span, $fcmTokens, $trip;

    public function __construct($trip)
    {
        $this->title = 'notifications.accepted_your_trip';
        $this->body = 'notifications.accepted_your_trip_txt';
        $this->trip = $trip;
        $this->fcmTokens = $trip->user->fcms->pluck('token')->toArray();
    }


    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.accepted_your_trip'))
            ->withBody(trans('notifications.accepted_your_trip_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => $this->trip->id,
            'image_path' => $this->trip->photo_thumb_path,
            'route' => "/trips_View",
        ];
    }
}
