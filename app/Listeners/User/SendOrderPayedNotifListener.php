<?php

namespace App\Listeners\User;

use App\Events\User\OrderPayed; 
use App\Notifications\User\SendOrderPayedNotif;

class SendOrderPayedNotifListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(OrderPayed $event)
    {
        $event->deal->trip->user->notify(new SendOrderPayedNotif($event->deal));
    }
}
