<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisposisiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $disposisi;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($disposisi, $user)
    {
        $this->disposisi = $disposisi;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.disposisi-notification')
            ->subject('Notifikasi Disposisi Baru')
            ->with([
                'no_surat' => $this->disposisi->no_surat,
                'perihal_surat' => $this->disposisi->perihal_surat,
                'user' => $this->user, 
            ]);
    }
}
