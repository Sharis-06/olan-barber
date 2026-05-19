<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Cita - Olan BarberShop',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_notification',
        );
    }

    public function attachments(): array
    {
        // Generar el PDF en memoria usando la vista del ticket
        $pdf = Pdf::loadView('admin.appointments.pdf', ['appointment' => $this->appointment])
            ->setPaper([0, 0, 480, 720]);

        // Adjuntar el PDF directamente desde los datos en memoria
        return [
            Attachment::fromData(fn () => $pdf->output(), 'ticket_cita_OB-' . str_pad($this->appointment->id, 5, '0', STR_PAD_LEFT) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
