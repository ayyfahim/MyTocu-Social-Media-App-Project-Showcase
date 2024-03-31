<?php

namespace App\Notifications\Journal;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JournalLikeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $like;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($like)
    {
        $this->like = $like;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $image = null;
        if ($this->like->likeable->journal_image) {
            $image = route('image.journal', $this->like->likeable->journal_image);
        }

        return [
            "like" => $this->like,
            "message" => $this->like->user->name . " has liked your journal.",
            "url" => route('journal.show', $this->like->likeable->slug),
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
        return 'journal.liked';
    }
}
