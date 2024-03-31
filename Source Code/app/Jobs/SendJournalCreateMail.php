<?php

namespace App\Jobs;

use App\Mail\JournalCreate;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendJournalCreateMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $journal, $friend;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($journal, $friend)
    {
        $this->journal = $journal;
        $this->friend = $friend;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->friend)->send(new JournalCreate($this->journal, $this->friend));
    }
}
