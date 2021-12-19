<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HandlerMails extends AbstractController{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;    
    }

    public function sendEmailForUserForgetPassword(User $user)
    {
        $email = (new TemplatedEmail())
            ->from('admin@snowtricks.com')
            ->to($user->getEmail())
            ->subject('Snowtricks - Réinitialiser votre mot de passe')
            ->htmlTemplate('mails/_forget_password.html.twig')
            ->context([
                "user" => $user        
            ])
        ;
        $this->mailer->send($email);

    }

    public function sendEmailForUserAccountValidation(User $user)
    {
        $email = (new TemplatedEmail())
            ->from('admin@snowtricks.com')
            ->to($user->getEmail())
            ->subject('Snowtricks - Validation de votre compte')
            ->htmlTemplate('mails/_validate_account.html.twig')
            ->context([
                "user" => $user        
            ])
        ;
        $this->mailer->send($email);

    }
    
}