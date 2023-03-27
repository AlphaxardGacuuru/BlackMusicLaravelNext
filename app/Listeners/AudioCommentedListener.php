<?php

namespace App\Listeners;

use App\Events\AudioCommentedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AudioCommentedListener
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
     * @param  \App\Events\AudioCommentedEvent  $event
     * @return void
     */
    public function handle(AudioCommentedEvent $event)
    {
        //
    }
}
