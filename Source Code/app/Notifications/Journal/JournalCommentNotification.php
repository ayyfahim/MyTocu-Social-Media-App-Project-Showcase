<?php

namespace App\Notifications\Journal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JournalCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $image = null;
        if ($this->comment->commentable->journal_image) {
            $image = route('image.journal', $this->comment->commentable->journal_image);
        }

        return [
            "comment" => $this->comment,
            "message" => $this->comment->user->name . " has commented on your journal: <b>" . $this->comment->body . "</b>",
            "url" => route('journal.show', $this->comment->commentable->id),
            "image" => $image,
        ];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'journal.commented';
    }
}
