<?php

namespace App\Jobs;

use App\Mail\ListCreate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendListCreateMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $list, $friend;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list, $friend)
    {
        $this->list = $list;
        $this->friend = $friend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->friend)->send(new ListCreate($this->list, $this->friend));
    }
}
