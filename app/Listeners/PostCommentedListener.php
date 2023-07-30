<?php

namespace App\Listeners;

use App\Events\PostCommentedEvent;
use App\Notifications\PostCommentedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostCommentedListener implements ShouldQueue
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
        $event
            ->post
            ->user
            ->notify(new PostCommentedNotification(
                $event->post,
                $event->user
            ));
    }
}
