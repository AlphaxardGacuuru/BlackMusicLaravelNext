<?php

namespace App\Listeners;

use App\Events\AudioCommentLikedEvent;
use App\Notifications\AudioCommentLikedNotification;

class AudioCommentLikedListener
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
     * @param  \App\Events\AudioCommentLikedEvent  $event
     * @return void
     */
    public function handle(AudioCommentLikedEvent $event)
    {
        if ($event->comment->user->username != auth('sanctum')->user()->username) {
            $event->comment->user->notify(new AudioCommentLikedNotification($event->comment, $event->audio));
        }
    }
}
