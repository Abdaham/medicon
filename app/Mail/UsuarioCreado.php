<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsuarioCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $nombre;
    public $pass;
    
    public function __construct($nombre,$email,$pass)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->pass = $pass;
    }

    public function build()
    {
        return $this->from('seanmav@gmail.com')
                    ->subject('Se ha registrado en Medicon')
                    ->view('mails.usuario');
    }
}
