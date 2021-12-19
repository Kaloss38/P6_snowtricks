<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HandlerUserSecurity extends AbstractController{

    private $em;
    private $handlerMails;

    public function __construct(EntityManagerInterface $em, HandlerMails $handlerMails)
    {
        $this->em = $em;
        $this->handlerMails = $handlerMails;
    }

    public function sendForgetPasswordLink(string $email)
    {
        $user = $this->em->getRepository(User::class)->findOneByEmail($email);
            
            if($user && $user->getIsValidated())
            {
                $token = bin2hex(random_bytes(100));
                
                $user->setToken($token);
                $this->em->flush();
                $this->handlerMails->sendEmailForUserForgetPassword($user);
                $this->addFlash('sucess', 'Un e-mail vous a été envoyé afin de réinitialiser votre mot de passe');
            }
            else{
                $this->addFlash('error', 'Une erreur est survenue, merci de vérifier vos informations');
            }
    }
    
}