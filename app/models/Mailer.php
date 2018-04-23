<?php 
 require_once __DIR__ . '/mailer/PHPMailer.php';
 require_once __DIR__ . '/mailer/SMTP.php';
 require_once __DIR__ . '/mailer/POP3.php';
 require_once __DIR__ . '/mailer/OAuth.php';
 require_once __DIR__ . '/mailer/Exception.php';
 
 use PHPMailer\PHPMailer\PHPMailer;

 class Mailer{
    public function getInstance(){
        return new PHPMailer();
    }
 }



?>