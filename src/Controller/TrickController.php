<?php

namespace App\Controller;

use DateTime;
use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Services\HandlerMedias;
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
    private $handlerMedias;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em, HandlerMedias $handlerMedias)
    {
        $this->slugger = $slugger;
        $this->em = $em;
        $this->handlerMedias = $handlerMedias;
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
            $trick->setUser($this->getUser());
            $dateTime = new DateTime();
            $trick->setCreatedAt($dateTime);
            
            $group = new Group();
            $group->setName($form['relatedGroup']->getData());
            $group->addTrick($trick);

            $thumbnail = $form['thumbnail']->getData();
            $this->handlerMedias->addPicture($thumbnail, $trick, 1);
            
            $pictures = $request->files->all()['trick']['media'];
            $this->handlerMedias->addPictures($pictures, $trick);

            $videos= $form['videos'];
            $this->handlerMedias->addVideo($videos, $trick);

            $this->em->persist($group);
            $this->em->persist($trick);    
            $this->em->flush();

            return $this->redirectToRoute('home');
        }
         
        return $this->render('trick/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick")
     */
    public function show(Trick $trick)
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick    
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit")
     */
    public function edit(Trick $trick)
    {
        return $this->render('trick/edit.html.twig', [
            
        ]);
    }

    /**
     * @Route("/trick/{id}/delete", name="trick_delete", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick)
    {
        
        if ($this->isCsrfTokenValid('trick_delete_' . $trick->getId(), $request->request->get('csrf_token'))) {
            $this->handlerMedias->deleteAllMedias($trick->getMedia());
            $this->em->remove($trick);
            
            $this->em->flush();
        }

        $this->addflash('success', 'Le trick a bien été supprimé.');

        return $this->redirectToRoute('home');
    }
}
