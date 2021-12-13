<?php

namespace App\Controller;

use App\Form\UserPictureType;
use App\Services\HandlerMedias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    private $handlerMedias;

    public function __construct(HandlerMedias $handlerMedias)
    {
        $this->handlerMedias = $handlerMedias;
    }
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserPictureType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newProfilPicture = $request->files->all()['user_picture']['image'];
            $this->handlerMedias->updateUserProfilPicture($newProfilPicture, $user);
            $this->addFlash('success', 'Votre commentaire à bien été ajouté');
        }

        

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'form' => $form->createView()    
        ]);
    }
}
