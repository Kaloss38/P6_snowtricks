<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentionsLegales(): Response
    {
        return $this->render('public/mentions-legales.html.twig');
    }
}
