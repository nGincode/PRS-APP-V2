<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $subject;
    public $kode;
    public $nama;
    public $jumlah;

    public function __construct($subject, $kode, $nama, $jumlah)
    {
        $this->subject = $subject;
        $this->kode = $kode;
        $this->nama = $nama;
        $this->jumlah = $jumlah;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('office@primarasaselaras.com')
            ->view('Email')
            ->subject($this->subject)
            ->with(
                [
                    'nama' => $this->nama,
                    'jumlah' => $this->jumlah,
                    'kode' => $this->kode
                ]
            );
    }
}
