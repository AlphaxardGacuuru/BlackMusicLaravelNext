<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\AudioCommentLikedEvent;
use App\Events\PostLikedEvent;
use App\Events\PostCommentedEvent;
use App\Events\FollowedEvent;
use App\Listeners\AudioCommentLikedListener;
use App\Listeners\PostLikedListener;
use App\Listeners\PostCommentedListener;
use App\Listeners\FollowedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
		],
		AudioCommentLikedEvent::class => [AudioCommentLikedListener::class],
		PostCommentedEvent::class => [PostCommentedListener::class],
		PostLikedEvent::class => [PostLikedListener::class],
		FollowedEvent::class => [FollowedListener::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
