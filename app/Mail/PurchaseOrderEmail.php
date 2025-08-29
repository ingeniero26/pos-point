<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\PDF;

class PurchaseOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    protected $pdf;
    protected $filename;

    /**
     * Create a new message instance.
     *
     * @param array $emailData
     * @param PDF $pdf
     * @param string $filename
     * @return void
     */
    public function __construct($emailData, $pdf, $filename)
    {
        $this->emailData = $emailData;
        $this->pdf = $pdf;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->emailData['subject'] ?? 'Orden de Compra')
                    ->view('emails.purchase_order')
                    ->attachData($this->pdf->output(), $this->filename);
    }
}