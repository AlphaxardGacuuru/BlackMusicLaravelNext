<?php

namespace App\Listeners;

use App\Events\KopokopoCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class KopokopoCreatedListener
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
        //
    }
}
