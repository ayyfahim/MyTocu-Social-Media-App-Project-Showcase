<?php

namespace App\Listeners;

use App\Events\ListLikeStored;
use Illuminate\Queue\InteractsWithQueue;
// use App\Notifications\ListLikeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Liste\ListLikeNotification;

class SendListLikeNotification
{
    /**
     * Handle the event.
     *
     * @param  ListLikeStored  $event
     * @return void
     */
    public function handle(ListLikeStored $event)
    {
        if ($event->like->likeable->user) {
            if (auth()->id() != $event->like->likeable->user->id) {

                $event->like->likeable->user->notify(new ListLikeNotification($event->like));
            }
        }
    }
}
