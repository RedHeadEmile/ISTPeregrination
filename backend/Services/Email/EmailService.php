<?php

namespace ISTPeregrination\Services\Email;

use ISTPeregrination\Common\SingletonTrait;
use PHPMailer\PHPMailer\PHPMailer;

class EmailService implements IEmailService
{
    use SingletonTrait;

    public function __construct()
    {
    }

    public function send(string $destAddress, string $destName, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['email_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['email_username'];
            $mail->Password = $_ENV['email_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($_ENV['email_fromaddr'], $_ENV['email_fromname']);
            $mail->addReplyTo($_ENV['email_replytoaddr'], $_ENV['email_replytoname']);

            $mail->addAddress($destAddress, $destName);

            $mail->Subject = $subject;
            $mail->msgHTML($body);

            return $mail->send();
        } catch (\Exception $e) {
            return false;
        }
    }
}