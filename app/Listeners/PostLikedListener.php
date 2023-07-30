<?php

namespace App\Listeners;

use App\Events\PostLikedEvent;
use App\Notifications\PostLikedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostLikedListener implements ShouldQueue
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
     * @param  \App\Events\PostLikedEvent  $event
     * @return void
     */
    public function handle(PostLikedEvent $event)
    {
        // Send Notification
        $event
            ->post
            ->user
            ->notify(new PostLikedNotification($event->post, $event->user));
    }
}
