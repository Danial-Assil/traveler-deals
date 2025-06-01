<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendOrderPickedUpNotif extends Notification
{
    use Queueable;
    private  $title, $body, $fcmTokens, $order;

    public function __construct($order)
    {
        $this->title = 'notifications.picked_your_order';
        $this->body = 'notifications.picked_your_order_txt';
        $this->order = $order;
        $this->fcmTokens = $order->user->fcms->pluck('token')->toArray();
    }


    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle(trans('notifications.picked_your_order'))
            ->withBody(trans('notifications.picked_your_order_txt'))
            ->withPriority('high')->asNotification($this->fcmTokens);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => $this->order->id,
            'image_path' => $this->order->image_thumb_path,
            'route' => "/traking_Order_For_Travaler",
        ];
    }
}
