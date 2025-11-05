<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomHtmlEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subjectText;
    public string $htmlContent;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subjectText, string $htmlContent)
    {
        $this->subjectText = $subjectText;
        $this->htmlContent = $htmlContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectText)
                    ->html($this->htmlContent);
    }
}