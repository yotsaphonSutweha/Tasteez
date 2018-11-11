<?php
namespace Tasteez\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

use PDO;

class Contact {

  public function sendEmail($email = "", $subject = "", $message = "") {
    if($email == "" || $subject == "" || $message == "") {
        return array("message" => "Some required fields have been left blank!");
    } else {
        $mail = new PHPMailer(true);

        $from = 'contact.tasteez@gmail.com';
        $password = 'madmanlar1994';
            try {
                $mail->Mailer = 'smtp';
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $from;
                $mail->Password = $password;
                $mail->Port = 587;

                $mail->setFrom($from);
                $mail->addAddress($from);
                $mail->Subject = $subject;
                $mail->Body = "New message from $email.\n$message";

                $mail->send();
                return array("message" => "Email Successfully sent!");
            } catch (Exception $e) {
                return array("message" => "Email Could not be sent!", "error" => $e);
            }
        }
    }

}
