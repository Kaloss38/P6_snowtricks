<?php

namespace App\Controller;

use App\Entity\Comment;
use DateTime;
use App\Entity\Group;
use App\Entity\Trick;
use App\Form\CommentType;
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
     * @Route("/trick/add", name="trick_add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $trick = new Trick();
        
        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug($trick->getName()));
            $trick->setUser($this->getUser());
            
            
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

            $this->addflash('success', 'Le trick a bien été créé.');

            return $this->redirectToRoute('home');
        }
         
        return $this->render('trick/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/{slug}", name="trick", methods={"GET", "POST"})
     */
    public function show(Trick $trick, Request $request)
    {
        $comment = new Comment();
        
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
            $this->em->persist($comment);
            $this->em->flush();
            
            $this->addFlash('success', 'Votre commentaire à bien été ajouté');
        }
        
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $form->createView()   
        ]);
    }

    /**
     * @Route("/trick/{slug}/edit", name="trick_edit", methods={"GET", "POST"})
     */
    public function edit(Trick $trick, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(TrickType::class, $trick, [
            'required' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug($this->slugger->slug($trick->getName()));
            $trick->getRelatedGroup()->setName($form['relatedGroup']->getData());
            $trick->setUpdatedAt(new DateTime());
            //update thumbnail
            $this->handlerMedias->updateThumbnail($trick, $form['thumbnail']->getData());
            //update images
            $medias = $request->files->all()['trick']['media'];
            $this->handlerMedias->updatePictures($trick, $medias);
            //update videos
            $videos = $form['videos'];
            $this->handlerMedias->updateVideos($trick, $videos);
            $this->em->flush();
            $this->addflash('success', 'Le trick a bien été modifié.');
            return $this->redirectToRoute('home');  
        }

        return $this->render('trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick    
        ]);
    }

    /**
     * @Route("/trick/{id}/delete", name="trick_delete", methods={"POST"})
     */
    public function delete(Request $request, Trick $trick)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('trick_delete_' . $trick->getId(), $request->request->get('csrf_token'))) {
            // $this->handlerMedias->deleteAllMedias($trick->getMedia());
            $this->em->remove($trick);
            
            $this->em->flush();

            $this->addflash('success', 'Le trick a bien été supprimé.');
        }

        return $this->redirectToRoute('home');
    }
}
