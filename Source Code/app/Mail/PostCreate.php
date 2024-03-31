<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $post, $friend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post, $friend)
    {
        $this->post = $post;
        $this->friend = $friend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->post->user->name . ' has created a post.')
            ->markdown('mail.post-create')
            ->with([
                'post' => $this->post,
                'url' => route('list.show', $this->post->list->slug),
                'friend' => $this->friend,
            ]);
    }
}
