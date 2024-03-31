<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $route, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($route, $user)
    {
        $this->route = $route;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->user->name.' wants to be your friend on MyTocu')
        ->markdown('mail.email-invite', [
                    'url' => $this->route,
                    'user' => $this->user,
                ]);
    }
}
