<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendNewNewsNotif extends Notification
{
    use Queueable;
    private  $title, $body, $news_item;

    public function __construct($news_item)
    {
        $this->title = 'notifications.new_order_offer';
        $this->body = 'notifications.new_order_offer';
        $this->news_item = $news_item;
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
            ->withPriority('high')
            ->withTopic('news');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'item_id' => intval($this->news_item->id),
            'image_path' => $this->news_item->image_thumb_path,
            'route' => "/offers_Order_View",
        ];
    }
}
