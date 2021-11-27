<?php

namespace App\Services;

use App\Entity\Media;
use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class HandlerMedias extends AbstractController{
    
    private $slugger;
    private $em;

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->slugger = $slugger;
    }

    public function addPicture(UploadedFile $file, Trick $trick, $isThumbnail = 0)
    {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            
            try {
                $file->move(
                    $this->getParameter('app.pictures.directory'),
                    $newFilename
                );
                $media = new Media();
                $media->setLink($newFilename);
                $media->setType('image');
                $media->setIsThumbnail($isThumbnail);
                $media->setTrick($trick);

                $this->em->persist($media);

            } catch (FileException $e) {
                $this->addFlash('error', "L'image ne s'est pas enregistrée.");
            }

            return $media;
    }

    public function addVideo(string $iframe,Trick $trick)
    {
        $media = new Media();
        $media->setLink($iframe);
        $media->setType('video');
        $media->setIsThumbnail(0);
        $media->setTrick($trick);

        $this->em->persist($media);  
        
        return $media;
    }
}