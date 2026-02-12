<?php

namespace App\Mail;

use App\Models\Pengguna;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengguna;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pengguna $pengguna)
    {
        $this->pengguna = $pengguna;
        $this->url = route('verification.verify', ['token' => $pengguna->token_verifikasi]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verifikasi Email Anda - E-Lapor Pemkab Pemalang')
                    ->view('emails.verify');
    }
}
