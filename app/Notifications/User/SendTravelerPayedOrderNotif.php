<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendTravelerPayedOrderNotif extends Notification
{
    use Queueable;
    private  $title, $body, $fcmTokens, $deal;

    public function __construct($deal)
    {
        $this->title = 'notifications.traveler_payed_order';
        $this->body = 'notifications.traveler_payed_order_txt';
        $this->deal = $deal;
        $this->fcmTokens = $deal->order->user->fcms->pluck('token')->toArray();
    }


    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.traveler_payed_order'))
            ->withBody(trans('notifications.traveler_payed_order_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => $this->deal->order_id,
            'image_path' => $this->deal->order->image_thumb_path,
            'route' => "/traking_Order",
        ];
    }
}
