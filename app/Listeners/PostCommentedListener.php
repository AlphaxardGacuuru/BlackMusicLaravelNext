<?php

namespace App\Listeners;

use App\Events\PostCommentedEvent;
use App\Notifications\PostCommentedNotification;

class PostCommentedListener
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
     * @param  \App\Events\PostCommentedEvent  $event
     * @return void
     */
    public function handle(PostCommentedEvent $event)
    {
		// Send Notification
        if ($event->post->username != auth('sanctum')->user()->username) {
            $event->post->user->notify(new PostCommentedNotification);
        }
    }
}
