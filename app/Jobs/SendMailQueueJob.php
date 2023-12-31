<?php

namespace App\Jobs;

use App\Mail\GMail;
use App\Mail\SendMailLater;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $mail = Mail::to($data['email']);
        if(isset($data['cc']) && sizeof($data['cc'])>0){
            $mail->cc($data['cc']);
        }
        $mail->later('60',new GMail($data));

    }
}
