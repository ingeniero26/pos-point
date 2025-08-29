<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $pdf;
    public $filename;

    /**
     * Create a new message instance.
     *
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
        return $this->subject($this->emailData['subject'])
            ->view('emails.quotation')
            ->attachData($this->pdf->output(), $this->filename, [
                'mime' => 'application/pdf',
            ]);
    }
}