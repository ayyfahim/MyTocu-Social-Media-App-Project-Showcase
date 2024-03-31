<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JournalCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $journal, $friend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($journal, $friend)
    {
        $this->journal = $journal;
        $this->friend = $friend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->journal->user->name . ' has created a Journal.')
            ->markdown('mail.journal-create')
            ->with([
                'journal' => $this->journal,
                'url' => route('journal.show', $this->journal->slug),
                'friend' => $this->friend,
            ]);
    }
}
