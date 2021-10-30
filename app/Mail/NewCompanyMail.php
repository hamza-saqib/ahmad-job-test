<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $Company;
    public function __construct($Company)
    {
        $this->Company = $Company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $Company = $this->Company;
        return $this->from('mailtrap@mailtrap.com')
                    ->subject('New Company Created')
                    ->view('emails/new-company-registered')
                    ->with([
                        'company'          => $Company,
                    ]);
    }
}
