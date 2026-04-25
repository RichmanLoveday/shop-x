<?php

namespace App\Mail;

use App\Models\Admin;
use App\Models\ProductFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DigitalFileUploadSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ProductFile $file,
        public User|Admin $user,
    ) {
        Log::info('Sending mail');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your file is ready 🎉',
        );
    }

    public function build()
    {
        return $this
            ->subject('Your file is ready 🎉')
            ->view('emails.digital-file-upload-success')
            ->with([
                'fileName' => $this->file->filename,
            ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.digital-file-upload-success',
            with: [
                'fileName' => $this->file->filename,
                'productName' => $this->file->product->name ?? 'Product',
                'creatorName' => $this->user->name ?? 'Unknown Creator',
                'user' => $this->file->product->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
