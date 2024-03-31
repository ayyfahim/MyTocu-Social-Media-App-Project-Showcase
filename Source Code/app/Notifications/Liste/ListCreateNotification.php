<?php

namespace App\Notifications\Liste;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ListCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $list;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($list)
    {
        $this->list = $list;
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
            "list" => $this->list,
            "message" => $this->list->user->name . " has created a list titled: <b>" . $this->list->title . "</b>",
            "url" => route('list.show', $this->list->id),
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
        return 'list.created';
    }
}
