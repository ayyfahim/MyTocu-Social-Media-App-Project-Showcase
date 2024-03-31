<?php

namespace App\Observers;

use App\Journal;
use App\Jobs\SendJournalCreateMail;
use App\Notifications\Journal\JournalCreateNotification;
use App\Notifications\Journal\JournalUpdateNotification;
// use App\Notifications\JournalCreateNotification;
// use App\Notifications\JournalUpdateNotification;

class JournalObserver
{
    /**
     * Handle the journal "created" event.
     *
     * @param  \App\Journal  $journal
     * @return void
     */
    public function created(Journal $journal)
    {
        foreach ($journal->user->getFriends() as $friend) {

            $friend->notify(new JournalCreateNotification($journal));

            if ($friend->e_notif == 1) {
                SendJournalCreateMail::dispatch($journal, $friend)->delay(now()->addSeconds(30));
            }
        }
    }

    /**
     * Handle the journal "updated" event.
     *
     * @param  \App\Journal  $journal
     * @return void
     */
    public function updated(Journal $journal)
    {
        foreach ($journal->user->getFriends() as $friend) {
            $friend->notify(new JournalUpdateNotification($journal));
        }
    }

    /**
     * Handle the journal "deleted" event.
     *
     * @param  \App\Journal  $journal
     * @return void
     */
    public function deleted(Journal $journal)
    {
        //
    }

    /**
     * Handle the journal "restored" event.
     *
     * @param  \App\Journal  $journal
     * @return void
     */
    public function restored(Journal $journal)
    {
        //
    }

    /**
     * Handle the journal "force deleted" event.
     *
     * @param  \App\Journal  $journal
     * @return void
     */
    public function forceDeleted(Journal $journal)
    {
        //
    }
}
