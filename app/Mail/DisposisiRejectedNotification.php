<?php

namespace App\Mail;

use App\Models\Disposisi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisposisiRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $disposisi;
    public $user;

    public function __construct(Disposisi $disposisi, $user)
    {
        $this->disposisi = $disposisi;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.disposisi_rejected')
            ->with([
                'disposisi' => $this->disposisi,
                'user' => $this->user,
            ]);
    }
}
