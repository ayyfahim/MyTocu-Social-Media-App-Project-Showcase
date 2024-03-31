<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FriendRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $sender, $recipient, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $recipient, $message)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->sender->name . $this->message)
            ->markdown('mail.friendship')
            ->with([
                'message' => $this->message,
                'sender' => $this->sender,
                'recipient' => $this->recipient,
                'url' =>  route('user.show', $this->sender->slug),
            ]);
    }
}
