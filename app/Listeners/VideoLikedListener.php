<?php

namespace App\Listeners;

use App\Events\VideoLikedEvent;
use App\Notifications\VideoLikedNotification;

class VideoLikedListener
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
     * @param  \App\Events\VideoLikedEvent  $event
     * @return void
     */
    public function handle(VideoLikedEvent $event)
    {
        if ($event->video->user->username != auth("sanctum")->user()->username) {
            $event->video->user->notify(new VideoLikedNotification($event->video));
        }
    }
}
