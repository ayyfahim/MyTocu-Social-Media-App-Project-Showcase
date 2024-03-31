<?php

namespace App\Listeners;

use App\Events\JournalLikeStored;
// use App\Notifications\JournalLikeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Journal\JournalLikeNotification;

class SendJournalLikeNotification
{

    /**
     * Handle the event.
     *
     * @param  JournalLikeStored  $event
     * @return void
     */
    public function handle(JournalLikeStored $event)
    {
        if ($event->like->likeable->user) {
            if (auth()->id() != $event->like->likeable->user->id) {
                $event->like->likeable->user->notify(new JournalLikeNotification($event->like));
            }
        }
    }
}
