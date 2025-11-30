<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Zakat;

class ZakatPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $zakat;

    /**
     * Create a new message instance.
     */
    public function __construct(Zakat $zakat)
    {
        $this->zakat = $zakat;
    }

    /**
     * Build the message.
     */
    public function build()
{
    return $this->subject('Pembayaran Zakat Berhasil')
                ->view('zakat.email'); // 
}
}
