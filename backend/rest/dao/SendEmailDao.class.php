<?php

require_once 'BaseDao.php';
require_once 'Config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmailDao extends BaseDao {
    
    public function __construct($config) {
        parent::__construct($config); // Pass the argument to the parent constructor
    }

    public function sendEmail($to, $toName, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = Config::SMTP_HOST();
            $mail->SMTPAuth = true;
            $mail->Username = Config::SMTP_USERNAME();
            $mail->Password = Config::SMTP_PASSWORD();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use the correct constant for encryption
            $mail->Port = Config::SMTP_PORT();

            $mail->setFrom('musa@example.com', 'Mailer');
            $mail->addAddress($to, $toName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}

?>
