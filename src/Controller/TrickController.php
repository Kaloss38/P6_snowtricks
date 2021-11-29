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
            $trick->setUser($this->getUser());
            $dateTime = new DateTime();
            $trick->setCreatedAt($dateTime);
            
            
            $group = new Group();
            $group->setName($form['relatedGroup']->getData());
            $group->addTrick($trick);

            $thumbnail = $form['thumbnail']->getData();
            $handlerMedias->addPicture($thumbnail, $trick, 1);
            
            $pictures = $request->files->all()['trick']['media'];
            $handlerMedias->addPictures($pictures, $trick);

            $videos= $form['videos'];
            $handlerMedias->addVideo($videos, $trick);

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
    public function show($slug)
    {

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
     * @Route("/trick/{id}/delete", name="trick_delete")
     */
    public function delete($slug)
    {

    }
}
