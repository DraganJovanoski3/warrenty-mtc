<?php

namespace App\Mail;

use App\Models\Installation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstallationClaimConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Installation $installation)
    {
    }

    public function envelope(): Envelope
    {
        $contact = (string) config('services.mtc.warranty_contact_email', 'warranty@mtctruckparts.com');

        return new Envelope(
            from: new Address(
                config('mail.from.address', $contact),
                config('mail.from.name', 'MTC Warranty')
            ),
            replyTo: [new Address($contact, 'MTC Warranty')],
            subject: 'MTC Warranty Claim Confirmation #'.$this->installation->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.installation-claim-confirmation',
            with: [
                'installation' => $this->installation,
                'contactEmail' => config('services.mtc.warranty_contact_email', 'warranty@mtctruckparts.com'),
            ],
        );
    }
}
