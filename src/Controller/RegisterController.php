<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Services\HandlerMails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    private $handlerMails;

    public function __construct(EntityManagerInterface $entityManager, HandlerMails $handlerMails)
    {
        $this->entityManager = $entityManager;
        $this->handlerMails = $handlerMails;
    }
    
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $token = bin2hex(random_bytes(100));
            $user->setToken($token);

            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->handlerMails->sendEmailForUserAccountValidation($user);
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Inscription prise en compte, Un e-mail vous a été envoyé afin de valider votre compte');
        }
        
        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
