<?php

namespace App\Console\Commands;

use App\User;
use App\Message;
use Carbon\Carbon;
use App\Mail\UnreadMessage;
use Illuminate\Console\Command;
use App\SendUserUnreadMessageMail;
use App\Jobs\SendUnreadMessageMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;

class SendUserUnreadMessagesMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'senduserunreadmessagemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will send an user an email if they have unread messages.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $receivers = User::whereHas('receivedMessages', function (Builder $query) {
            $query->where([
                ['created_at', '>', now()->subDay()],
                ["created_at", "<", now()]
            ]);
            $query->whereNull('seen_at');
        })->get();

        foreach ($receivers as $user) {
            $unread_received_messages = \App\Message::where('receiver_id', $user->id)->whereNull('seen_at')->where([
                ['created_at', '>', now()->subDay()],
                ["created_at", "<", now()]
            ])->get()->groupBy('user_id');

            foreach ($unread_received_messages as $messages) {
                $last_message = $messages->last();
                $this->dispatchMail($user, $last_message);
            }
        }
    }

    public function dispatchMail($user, $message)
    {
        if (!$this->sendUserUnreadMessageMailExist($message)) {
            return false;
        }

        // Create a Token
        SendUserUnreadMessageMail::create([
            'user_id' => $message->user_id,
            'receiver_id' => $message->receiver_id,
        ]);

        // Sending the mail
        SendUnreadMessageMail::dispatch($user, $message)->delay(now()->addSeconds(30));
    }

    public function sendUserUnreadMessageMailExist($message)
    {

        $exist = SendUserUnreadMessageMail::where([
            'user_id' => $message->user_id,
            'receiver_id' => $message->receiver_id,
        ])->first();

        if ($exist) {
            return false;
        }

        return true;
    }
}
