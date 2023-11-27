<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $for_title;
    protected $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;
    public function __construct($data = array())
    {
        $this->subject = $data['subject'];
        $this->for_title = $data['for_title'];
        $this->msg = $data['msg'];
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.email-template')
            ->from('han-demo@handemo.test', 'HanDemo')
            ->subject($this->subject)
            ->with([
                'for_title'=>$this->for_title,
                'msg'=>$this->msg,
            ]);
    }
}
