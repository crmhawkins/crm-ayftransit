<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PresupuestoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cliente, $pdf)
    {
        $this->cliente = $cliente;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.presupuesto')
                    ->subject('Presupuesto Solicitado')
                    ->attachData($this->pdf, 'presupuesto.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
