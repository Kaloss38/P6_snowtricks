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
            
            $picturesCount = count($form['medias']->getData());
            
            for($i = 0; $i < $picturesCount; $i++)
            {
                $picture = $form['medias'][$i]['picturefile']->getData();

                $newPicture = $handlerMedias->addPicture($picture, $trick);

                $trick->addMedium($newPicture);
            }

            $videosCount = count($form['videos']->getData());

            for($i = 0; $i < $videosCount; $i++)
            {
                $video = $form['videos'][$i]['videoframe']->getData();
                
                $newVideo = $handlerMedias->addVideo($video, $trick);

                $trick->addMedium($newVideo);

            }  

            
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
    public function edit($slug)
    {

    }

    /**
     * @Route("/trick/{id}/delete", name="trick_delete")
     */
    public function delete($slug)
    {

    }
}
