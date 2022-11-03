<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7e1f7247b9876f';
        $mail->Password = '0ce59f0b64df75';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'uptask.com');
        $mail->Subject = 'Confirma tu cuenta en UpTask';
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= "<p><strong> Hola " . $this->nombre .   " <br><br></strong>
        Has Creado tu cuenta en UpTask, <br><br><br>Confírmala en el siguiente enlace</p>";
        $contenido .= "<br><p> Presiona Aquí: <a href='http://localhost:6969/confirmar?token=" . $this->token . "'> Confirmar Cuenta</a> </p>";
        $contenido .= "<br> <p> Si tú no creaste esta cuenta, por favor ignora este mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar email
        $mail->send();
    }
}