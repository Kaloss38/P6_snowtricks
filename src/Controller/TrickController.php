<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Services\HandlerMedias;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{
    private $slugger;
    private $em;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->slugger = $slugger;
        $this->em = $em;
    }

    /**
     * @Route("/trick/add", name="trick_add")
     */
    public function add(Request $request, HandlerMedias $handlerMedias): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug($trick->getName()));
            $trick->setAuthor($this->getUser()->getPseudo());
            $dateTime = new DateTime();
            $trick->setCreatedAt($dateTime);
            
            $thumbnail = $form['thumbnail']->getData();
            $newThumbnail = $handlerMedias->addThumbnail($thumbnail, $trick);
            $trick->addMedium($newThumbnail);
            $this->em->persist($newThumbnail);
            $this->em->persist($trick);
            $this->em->flush();
        }
         

        
        return $this->render('trick/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function show($slug)
    {

    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     */
    public function edit($slug)
    {

    }

    /**
     * @Route("/trick/{slug}/delete", name="trick_delete")
     */
    public function delete($slug)
    {

    }
}
