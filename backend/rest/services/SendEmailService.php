<?php

require_once 'SendEmailDao.php';

class SendEmailService {

    private $sendEmailDao;

    public function __construct($config) {
        $this->sendEmailDao = new SendEmailDao($config); // Pass the argument
    }

    public function sendVerificationEmail($to, $toName, $subject, $body) {
        $this->sendEmailDao->sendEmail($to, $toName, $subject, $body);
    }
}

?>
