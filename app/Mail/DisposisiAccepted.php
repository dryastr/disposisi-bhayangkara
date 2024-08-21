<?php

namespace App\Mail;

use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisposisiAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $disposisi;
    public $karumkit;

    public function __construct(Disposisi $disposisi, User $karumkit)
    {
        $this->disposisi = $disposisi;
        $this->karumkit = $karumkit;
    }

    public function build()
    {
        return $this->view('emails.disposisi_accepted')
            ->with([
                'disposisi' => $this->disposisi,
                'karumkit' => $this->karumkit,
            ]);
    }
}
