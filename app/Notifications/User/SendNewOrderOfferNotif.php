<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendNewOrderOfferNotif extends Notification
{
    use Queueable;
    private  $title, $body, $life_span, $fcmTokens, $order_offer;

    public function __construct($order_offer)
    {
        $this->title = 'notifications.new_order_offer';
        $this->body = 'notifications.new_order_offer';
        $this->order_offer = $order_offer;
        $this->fcmTokens = $order_offer->order->user->fcms->pluck('token')->toArray();
    }

    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.new_order_offer'))
            ->withBody(trans('notifications.new_order_offer_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => intval($this->order_offer->order_id),
            'image_path' => asset('assets/dash/img/trip.png'),
            'route' => "/offers_Order_View",
        ];
    }
}
