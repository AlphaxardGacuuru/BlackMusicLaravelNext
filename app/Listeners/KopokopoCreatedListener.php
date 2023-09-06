<?php

namespace App\Listeners;

use App\Events\KopokopoCreatedEvent;
use App\Notifications\KopokopoReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class KopokopoCreatedListener implements ShouldQueue
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

    /**
     * Handle the event.
     *
     * @param  \App\Events\KopokopoCreatedEvent  $event
     * @return void
     */
    public function handle(KopokopoCreatedEvent $event)
    {
        $event->user->notify(new KopokopoReceivedNotification($event->kopokopo));
    }
}
