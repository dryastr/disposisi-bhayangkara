<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisposisiSent extends Mailable
{
    use Queueable, SerializesModels;

    public $disposisi;
    public $karumkit;

    public function __construct($disposisi, $karumkit)
    {
        $this->disposisi = $disposisi;
        $this->karumkit = $karumkit;
    }

    public function build()
    {
        return $this->subject('Disposisi Dikirim')
            ->view('emails.disposisi_sent');
    }
}
