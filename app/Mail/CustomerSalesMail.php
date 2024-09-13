<?php

namespace App\Mail;

use App\Models\SalesMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerSalesMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public SalesMail $salesMail)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function build(){
        return $this->to($this->salesMail->recipient)
        ->subject($this->salesMail->subject)
        ->view('salesmail.content')->with(['subject'=>$this->salesMail->subject,
        'body'=>$this->salesMail->body]);
    }
    // public function envelope(): Envelope
    // {
    //    return new Envelope(
//     from: new Address('jeffrey@example.com', 'Jeffrey Way'),
//     replyTo: [
//         new Address('taylor@example.com', 'Taylor Otwell'),
//     ],
//     subject: 'Order Shipped',
// );
    // }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           view: 'salesmail.content'
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
