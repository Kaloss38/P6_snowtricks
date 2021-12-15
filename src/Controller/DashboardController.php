<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPictureType;
use App\Services\HandlerMedias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{
    private $handlerMedias;

    public function __construct(HandlerMedias $handlerMedias)
    {
        $this->handlerMedias = $handlerMedias;
    }
    /**
     * @Route("/dashboard/{id}", name="dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, User $user): Response
    {
        $this->isGranted("view", $user);
        $user = $this->getUser();

        $form = $this->createForm(UserPictureType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newProfilPicture = $request->files->all()['user_picture']['image'];
            $this->handlerMedias->updateUserProfilPicture($newProfilPicture, $user);
            $this->addFlash('success', 'Votre photo de profil à été mise à jour');
        }

        

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()    
        ]);
    }
}
