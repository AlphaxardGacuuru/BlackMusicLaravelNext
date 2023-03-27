<?php

namespace App\Listeners;

use App\Events\AudioLikedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AudioLikedListener
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
     * @param  \App\Events\AudioLikedEvent  $event
     * @return void
     */
    public function handle(AudioLikedEvent $event)
    {
        //
    }
}
