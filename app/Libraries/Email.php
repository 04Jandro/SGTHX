<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require APPPATH . 'ThirdParty/PHPMailer/src/Exception.php';
require APPPATH . 'ThirdParty/PHPMailer/src/PHPMailer.php';
require APPPATH . 'ThirdParty/PHPMailer/src/SMTP.php';

class Email {

    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'utede.com.co'; // Cambia esto por tu servidor SMTP
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'pruebas@utede.com.co'; // Cambia esto
            $this->mail->Password = 'Pruebas.Utede'; // Cambia esto
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587; // Cambiado a 587 porque STARTTLS usa este puerto
            // Configurar codificación UTF-8
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Encoding = 'base64';
            
            // Remitente
            $this->mail->setFrom('pruebas@utede.com.co', 'UtedePruebas');
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            log_message('error', "Error en Email: " . $e->getMessage());
        }
    }

    public function enviarCorreo($destinatario, $asunto, $mensaje) {
        try {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();
            $this->mail->addAddress($destinatario);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $mensaje;

            if ($this->mail->send()) {
                log_message('info', "Correo enviado correctamente a $destinatario.");
                return true;
            } else {
                log_message('error', "Error al enviar correo: " . $this->mail->ErrorInfo);
                return false;
            }
        } catch (Exception $e) {
            log_message('error', "Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
}
