<?php

namespace App\Observers;

use App\Post;
use App\Jobs\SendPostCreateMail;
use App\Notifications\Post\PostCreateNotification;
use App\Notifications\Post\PostUpdateNotification;
// use App\Notifications\PostCreateNotification;
// use App\Notifications\PostUpdateNotification;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if ($post->list->posts->count() > 1) {
            foreach (auth()->user()->getFriends() as $friend) {

                $friend->notify(new PostCreateNotification($post));

                if ($friend->e_notif == 1) {
                    SendPostCreateMail::dispatch($post, $friend)->delay(now()->addMinutes(1));
                }
            }
        }
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        foreach ($post->user->getFriends() as $friend) {
            $friend->notify(new PostUpdateNotification($post));
        }
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
