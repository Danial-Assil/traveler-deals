<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendNewTripRequestNotif extends Notification
{
    use Queueable;
    private  $title, $body, $life_span, $fcmTokens, $trip_request;

    public function __construct($trip_request)
    {
        $this->title = 'notifications.new_trip_request';
        $this->body = 'notifications.new_trip_request_txt';
        $this->trip_request = $trip_request;
        $this->fcmTokens = $trip_request->trip->user->fcms->pluck('token')->toArray();
    }



    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.new_trip_request'))
            ->withBody(trans('notifications.new_trip_request_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => intval($this->trip_request->trip_id),
            'image_path' => $this->trip_request->order->image_thumb_path,
            'route' => "/trip-offers",
        ];
    }
}
