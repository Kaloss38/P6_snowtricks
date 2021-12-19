<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\HandlerMails;
use App\Form\ForgetPasswordType;
use App\Form\ReinitPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    private $em;
    private $handlerMails;

    public function __construct(EntityManagerInterface $em, HandlerMails $handlerMails)
    {
        $this->em = $em;
        $this->handlerMails = $handlerMails;
    }

    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/mot-de-passe-oublie", name="app_reset_password", methods={"GET","POST"})
     */
    public function forgetPassword(Request $request): Response
    {
        $form = $this->createForm(ForgetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();

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

        return $this->render('security/forget_password.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/reinitialisation-mot-de-passe/{token}", name="app_edit_password", methods={"GET","POST"})
     */
    public function ReinitPassword(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(ReinitPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $request->get('token');
            
            $user = $this->em->getRepository(User::class)->findOneBy(['token' => $token]);
            $newPassword = $hasher->hashPassword($user, $form['password']->getData());
            
            $user->setPassword($newPassword);
            $user->setToken(null);
            
            $this->em->flush();

            $this->addFlash('sucess', 'Votre mot de passe a bien été modifié, connectez-vous !');  
            
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reinit_password.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/validation-compte/{token}", name="app_account_validation", methods={"GET","POST"})
     */
    public function validateUserAccount(Request $request): Response
    {
            $token = $request->get('token');
            
            $user = $this->em->getRepository(User::class)->findOneBy(['token' => $token]);
            $user->setIsValidated(1);
            $user->setToken(null);
            
            $this->em->flush();

            $this->addFlash('sucess', 'Votre compte a bien été validé, vous pouvez maintenant vous connectez');  
            
            return $this->redirectToRoute('app_login');
    }
}
