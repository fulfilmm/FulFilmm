<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ExpCliamEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $details;
    public function __construct($details)
    {
        $this->details=$details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details=$this->details;
        dd($details);
        Mail::send('transaction.ExpenseClaim.email', $this->details, function ($message) use ($details) {
            $message->from('siyincin@gmail.com', 'Cloudark');
            $message->to($details['email']);
            $message->subject($details['subject']);
        });
    }
}
