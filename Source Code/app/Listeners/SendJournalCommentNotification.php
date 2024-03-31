<?php

namespace App\Listeners;

use App\Events\JournalCommentStored;
// use App\Notifications\JournalCommentNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Journal\JournalCommentNotification;

class SendJournalCommentNotification
{
    /**
     * Handle the event.
     *
     * @param  JournalCommentStored  $event
     * @return void
     */
    public function handle(JournalCommentStored $event)
    {
        if ($event->comment->commentable->user) {

            if (auth()->id() != $event->comment->commentable->user->id) {

                $event->comment->commentable->user->notify(new JournalCommentNotification($event->comment));
            }
        }
    }
}
