<?php

namespace App\Listeners;

use App\Jobs\SendFriendRequestMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FriendRequest\FriendRequestSentNotification;

class SendFriendRequestSentNotificationAndMail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (auth()->id() != $event->recipient->id) {

            $event->recipient->notify(new FriendRequestSentNotification($event->sender, $event->recipient));

            if ($event->recipient->e_notif == 1) {
                $message = " has sent you a friend request.";
                SendFriendRequestMail::dispatch($event->sender, $event->recipient, $message)->delay(now()->addSeconds(30));
            }
        }
    }
}
