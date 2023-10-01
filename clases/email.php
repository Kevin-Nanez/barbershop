<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer; 

use PHPMailer\PHPMailer\Exception;  


class email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token)
    {
        $this->email= $email;
        $this->nombre= $nombre;
        $this->token= $token;
    }

    public function enviarToken(){
        //crear el email como un objeto
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '639e5593b0d2c9';
        $mail->Password = '4e0645e2087c89';
        
        $mail->SMTPSecure = "tls";
        // quien envia el emali
        $mail->setFrom('tigresdecorason2304ipd@gmail.com');
        // donde se recibe el email
        $mail->addAddress($this->email,'AnuelAA.com');
        $mail->Subject = "Confirma tu cuenta";

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .="<p><strong>Hola ".$this->nombre ." </strong> Has creado tu cuenta, confirmala presionando el siguiente enlace:</p> <br>";
        $contenido .= "<p>Confirmar cuenta: <a href='http://localhost:3000/confirmar?token=".$this->token."'>Click Aquí</a></p>";
        $contenido.= "Si tu no solicitaste esta cuenta, ignora el mensaje";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();

    }

}


?>