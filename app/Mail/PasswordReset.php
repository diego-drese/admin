<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class PasswordReset extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $url = Config::get('app.url_password_reset').'?token='.$this->data->token;
        return $this->subject('Notificação de redefinição de senha')
            ->markdown('email.password.reset', ['data' => $this->data, 'url'=>$url]);
    }
}

