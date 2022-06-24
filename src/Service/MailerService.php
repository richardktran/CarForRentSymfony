<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MailerService
{
    private array $emailConfig;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->emailConfig = $parameterBag->get('emailConfig');
    }

    /**
     * @throws Exception
     */
    public function send(string $customerEmail, string $customerName): void
    {
        $smtp = $this->emailConfig['smtp'];
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->emailConfig['username'];
        $mail->Password = $this->emailConfig['password'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $smtp['port'];

        $mail->setFrom($this->emailConfig['username'], $this->emailConfig['name']);
        $mail->addAddress($customerEmail, $customerName);

        $mail->isHTML(true);
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold! </b>  with code:' . uniqid();
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    }
}
