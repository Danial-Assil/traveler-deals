<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendOrderOfferAcceptedNotif extends Notification
{
    use Queueable;
    private  $title, $body, $life_span, $fcmTokens, $order_offer;

    public function __construct($order_offer)
    {
        $this->title = 'notifications.accepted_your_offer';
        $this->body = 'notifications.accepted_your_offer_txt';
        $this->order_offer = $order_offer;
        $this->fcmTokens = $order_offer->trip->user->fcms->pluck('token')->toArray();
    }


    
    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.accepted_your_offer'))
            ->withBody(trans('notifications.accepted_your_offer_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => intval($this->order_offer->trip_id),
            'image_path' => $this->order_offer->order->image_thumb_path,
            'route' => null,
        ];
    }
}
