<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnreadMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have one unread message from ' . $this->message->user->name)
            ->markdown('mail.unread-message', [
                'user' => $this->user,
                'message' => $this->message,
            ]);
    }
}
