<?php

namespace App\Listeners;

use App\Events\ListCommentStored;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Liste\ListCommentNotification;
// use App\Notifications\ListCommentNotification;

class SendListCommentNotification
{

    /**
     * Handle the event.
     *
     * @param  ListCommentStored  $event
     * @return void
     */
    public function handle(ListCommentStored $event)
    {
        if ($event->comment->commentable->user) {

            if (auth()->id() != $event->comment->commentable->user->id) {

                $event->comment->commentable->user->notify(new ListCommentNotification($event->comment));
            }
        }
    }
}
