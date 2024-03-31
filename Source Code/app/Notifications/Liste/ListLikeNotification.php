<?php

namespace App\Notifications\Liste;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ListLikeNotification extends Notification implements ShouldQueue
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

    public function toArray($notifiable)
    {
        return [
            "like" => $this->like,
            "message" => $this->like->user->name . " has liked your list: <b>" . $this->like->likeable->title . "</b>",
            "url" => route('list.show', $this->like->likeable->slug),
            "image" => null,
        ];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'list.liked';
    }
}
