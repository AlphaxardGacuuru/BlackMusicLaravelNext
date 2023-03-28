<?php

namespace App\Listeners;

use App\Events\VideoCommentLikedEvent;
use App\Notifications\VideoCommentLikedNotification;

class VideoCommentLikedListener
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
     * @param  \App\Events\VideoCommentLikedEvent  $event
     * @return void
     */
    public function handle(VideoCommentLikedEvent $event)
    {
        if ($event->comment->user->username != auth("sanctum")->user()->username) {
            $event->comment->user->notify(new VideoCommentLikedNotification($event->comment));
        }
    }
}
