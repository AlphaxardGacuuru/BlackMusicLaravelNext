<?php

namespace App\Listeners;

use App\Events\ChatEvent;
use App\Notifications\ChatNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChatListener implements ShouldQueue
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
     * @param  \App\Events\ChatEvent  $event
     * @return void
     */
    public function handle(ChatEvent $event)
    {
        $event->user->notify(new ChatNotification);
    }
}
