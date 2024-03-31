<?php

namespace App\Listeners;

use App\Events\PostLikeStored;
// use App\Notifications\PostLikeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Post\PostLikeNotification;

class SendPostLikeNotification
{
    /**
     * Handle the event.
     *
     * @param  PostLikeStored  $event
     * @return void
     */
    public function handle(PostLikeStored $event)
    {
        if ($event->like->likeable->user) {
            if (auth()->id() != $event->like->likeable->user->id) {

                $event->like->likeable->user->notify(new PostLikeNotification($event->like));
            }
        }
    }
}
