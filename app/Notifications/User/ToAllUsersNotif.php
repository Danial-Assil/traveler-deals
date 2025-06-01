<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// use Kutia\Larafirebase\Messages\FirebaseMessage;
use GGInnovative\Larafirebase\Messages\FirebaseMessage;

class ToAllUsersNotif extends Notification
{
    use Queueable;
    private  $title, $body;

    public function __construct()
    {
        $this->title = 'mmessage to all';
        $this->body = 'message to alllllll';
    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle('mmessage to all')
            ->withBody('message to alllllll')
            ->withTopic('all')
            ->withPriority('high');
    }
}
