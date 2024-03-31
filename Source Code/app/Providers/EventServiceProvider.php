<?php

namespace App\Providers;

use Demency\Friendships\Events\Sent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Demency\Friendships\Events\Accepted;
use App\Listeners\SendFriendRequestSentNotificationAndMail;
use App\Listeners\SendFriendRequestAcceptedNotificationAndMail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Sent::class => [
            SendFriendRequestSentNotificationAndMail::class,
        ],
        Accepted::class => [
            SendFriendRequestAcceptedNotificationAndMail::class,
        ],
        \App\Events\JournalCommentStored::class => [
            \App\Listeners\SendJournalCommentNotification::class,
        ],
        \App\Events\ListCommentStored::class => [
            \App\Listeners\SendListCommentNotification::class,
        ],
        \App\Events\JournalLikeStored::class => [
            \App\Listeners\SendJournalLikeNotification::class,
        ],
        \App\Events\ListLikeStored::class => [
            \App\Listeners\SendListLikeNotification::class,
        ],
        \App\Events\PostLikeStored::class => [
            \App\Listeners\SendPostLikeNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
