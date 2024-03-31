<?php

namespace App\Notifications\Journal;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JournalCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $journal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($journal)
    {
        $this->journal = $journal;
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
        if ($this->journal->journal_image) {
            $image = route('image.journal', $this->journal->journal_image);
        }

        return [
            "journal" => $this->journal,
            "message" => $this->journal->user->name . " has created a jorunal.",
            "url" => route('journal.show', $this->journal->slug),
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
        return 'journal.created';
    }
}
