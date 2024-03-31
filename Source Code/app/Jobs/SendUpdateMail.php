<?php

namespace App\Jobs;

use App\Mail\UpdateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendUpdateMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email, $route, $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $route, $user)
    {
        $this->email = $email;
        $this->route = $route;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new UpdateMail($this->user, $this->route));
    }
}
