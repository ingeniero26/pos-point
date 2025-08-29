<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sales;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sales $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.sales.email_template', [
            'sale' => $this->sale
        ])
                    ->attachData(
                        \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.sales.pdf', ['sale' => $this->sale])->output(),
                        'factura-' . $this->sale->invoice_no . '.pdf',
                        [
                            'mime' => 'application/pdf'
                        ]
                    );
    }
}
