<?php

namespace App\Jobs;

use App\Mail\PostCreate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPostCreateMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post, $friend;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $friend)
    {
        $this->post = $post;
        $this->friend = $friend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->friend)->send(new PostCreate($this->post, $this->friend));
    }
}
