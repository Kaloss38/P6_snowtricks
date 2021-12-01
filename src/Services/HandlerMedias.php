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
            $newPicture = $this->movePicture($file);
            $this->savePicture($trick, $newPicture, $isThumbnail);
    }

    public function addPictures(array $pictures, Trick $trick)
    {
        foreach($pictures as $key => $picture)
        {
            $newPicture = $this->movePicture($picture['picturefile']);
            $trick->getMedia()->toArray()[$key]->setType('image');
            $trick->getMedia()->toArray()[$key]->setIsThumbnail(0);
            $trick->getMedia()->toArray()[$key]->setLink($newPicture);
        }
    }

    private function movePicture(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        
        try {
            $file->move(
                $this->getParameter('app.pictures.directory'),
                $newFilename
            );
            
            
        } catch (FileException $e) {
            $this->addFlash('error', "L'image ne s'est pas enregistrée.");
        }

        return $newFilename;    
    }
    

    private function savePicture(Trick $trick, $newFilename, $isThumbnail)
    {
        $media = new Media();
        $media->setLink($newFilename);
        $media->setType('image');
        $media->setIsThumbnail($isThumbnail);
        $media->setTrick($trick); 

        $trick->addMedium($media);
        
        $this->em->persist($media);

        return $media ;
    }

    public function addVideo($videos,Trick $trick)
    {
        foreach($videos as $key => $video)
        {
            $newVideo = $videos[$key]['videoframe']->getData();

            $media = new Media();
            $media->setLink($newVideo);
            $media->setType('video');
            $media->setIsThumbnail(0);
            $media->setTrick($trick);

            $trick->addMedium($media);

            $this->em->persist($media);  
        }
    }

    public function deleteAllMedias($medias)
    {
        foreach($medias as $media)
        {
            $this->em->remove($media);
        }
    }
}