<?php

namespace App\Listeners;

use App\Jobs\SendFriendRequestMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\FriendRequest\FriendRequestAcceptNotification;

class SendFriendRequestAcceptedNotificationAndMail
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

            $event->recipient->notify(new FriendRequestAcceptNotification($event->sender, $event->recipient));

            if ($event->recipient->e_notif == 1) {
                $message = " has accepted your friend request.";
                SendFriendRequestMail::dispatch($event->sender, $event->recipient, $message)->delay(now()->addSeconds(30));
            }
        }
    }
}
