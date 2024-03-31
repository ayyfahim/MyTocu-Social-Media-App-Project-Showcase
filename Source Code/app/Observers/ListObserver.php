<?php

namespace App\Observers;

use App\Liste;
use App\Jobs\SendListCreateMail;
use App\Notifications\Liste\ListCreateNotification;
// use App\Notifications\ListCreateNotification;

class ListObserver
{
    /**
     * Handle the liste "created" event.
     *
     * @param  \App\Liste  $list
     * @return void
     */
    public function created(Liste $list)
    {
        foreach ($list->user->getFriends() as $friend) {

            $friend->notify(new ListCreateNotification($list));

            if ($friend->e_notif == 1) {
                SendListCreateMail::dispatch($list, $friend)->delay(now()->addSeconds(30));
            }
        }
    }

    /**
     * Handle the liste "updated" event.
     *
     * @param  \App\Liste  $list
     * @return void
     */
    public function updated(Liste $list)
    {
        //
    }

    /**
     * Handle the liste "deleted" event.
     *
     * @param  \App\Liste  $list
     * @return void
     */
    public function deleted(Liste $list)
    {
        //
    }

    /**
     * Handle the liste "restored" event.
     *
     * @param  \App\Liste  $list
     * @return void
     */
    public function restored(Liste $list)
    {
        //
    }

    /**
     * Handle the liste "force deleted" event.
     *
     * @param  \App\Liste  $list
     * @return void
     */
    public function forceDeleted(Liste $list)
    {
        //
    }
}
