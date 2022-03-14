<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class envioEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $contenido;
    public $template;
    public $asunto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contenido, $template, $asunto)
    {
        $this->contenido    = $contenido;
        $this->template     = $template;
        $this->asunto       = $asunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->asunto)
                    ->view($this->template);
    }
}
