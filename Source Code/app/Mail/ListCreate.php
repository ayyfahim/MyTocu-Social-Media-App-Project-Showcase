<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $list, $friend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($list, $friend)
    {
        $this->list = $list;
        $this->friend = $friend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->list->user->name . ' has created a list.')
            ->markdown('mail.list-create')
            ->with([
                'list' => \App\Liste::find($this->list->id),
                'url' => route('list.show', $this->list->slug),
                'friend' => $this->friend,
            ]);
    }
}
