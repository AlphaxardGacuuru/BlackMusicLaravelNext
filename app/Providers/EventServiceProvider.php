<?php

namespace App\Providers;

use App\Events\AudioBoughtEvent;
use App\Events\AudioCommentedEvent;
use App\Events\AudioCommentLikedEvent;
use App\Events\AudioLikedEvent;
use App\Events\FollowedEvent;
use App\Events\PostCommentedEvent;
use App\Events\PostCommentLikedEvent;
use App\Events\PostLikedEvent;
use App\Events\VideoBoughtEvent;
use App\Events\VideoCommentedEvent;
use App\Events\VideoCommentLikedEvent;
use App\Events\VideoLikedEvent;
use App\Listeners\AudioBoughtListener;
use App\Listeners\AudioCommentedListener;
use App\Listeners\AudioCommentLikedListener;
use App\Listeners\AudioLikedListener;
use App\Listeners\FollowedListener;
use App\Listeners\PostCommentedListener;
use App\Listeners\PostCommentLikedListener;
use App\Listeners\PostLikedListener;
use App\Listeners\VideoBoughtListener;
use App\Listeners\VideoCommentedListener;
use App\Listeners\VideoCommentLikedListener;
use App\Listeners\VideoLikedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        VideoLikedEvent::class => [VideoLikedListener::class],
        VideoCommentedEvent::class => [VideoCommentedListener::class],
        VideoCommentLikedEvent::class => [VideoCommentLikedListener::class],
        AudioLikedEvent::class => [AudioLikedListener::class],
        AudioCommentedEvent::class => [AudioCommentedListener::class],
        AudioCommentLikedEvent::class => [AudioCommentLikedListener::class],
        VideoBoughtEvent::class => [VideoBoughtListener::class],
        AudioBoughtEvent::class => [AudioBoughtListener::class],
        PostLikedEvent::class => [PostLikedListener::class],
        PostCommentedEvent::class => [PostCommentedListener::class],
        PostCommentLikedEvent::class => [PostCommentLikedListener::class],
        FollowedEvent::class => [FollowedListener::class],
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
