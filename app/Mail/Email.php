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
    public $img_voc;
    public $barcode;
    public $nama;
    public $jumlah;

    public function __construct($subject, $img_voc, $barcode, $nama, $jumlah)
    {
        $this->subject = $subject;
        $this->img_voc = $img_voc;
        $this->barcode = $barcode;
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
                    'img_voc' => $this->img_voc,
                    'barcode' => $this->barcode,
                    'nama' => $this->nama,
                    'jumlah' => $this->jumlah,
                ]
            );
    }
}
