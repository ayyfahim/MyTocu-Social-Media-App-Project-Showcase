<?php

namespace App\Jobs;

use App\Mail\FriendRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendFriendRequestMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sender, $recipient, $message;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipient)->send(new FriendRequest($this->sender, $this->recipient, $this->message));
    }
}
