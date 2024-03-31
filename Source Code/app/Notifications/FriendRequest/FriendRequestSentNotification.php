<?php

namespace App\Notifications\FriendRequest;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class FriendRequestSentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $sender, $receiver;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $receiver)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
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
            "message" => $this->sender->name . " has sent you a friend request",
            "url" => route('user.show', $this->sender->slug),
            "image" => route('image.account', $this->sender->user_image),
        ];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'friend.request.sent';
    }
}
