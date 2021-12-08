<?php

namespace App\Services;

use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\User;
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

    private function movePicture(UploadedFile $file, User $user = null)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        
        try {
            
            if($user)
            {
                $file->move(
                    $this->getParameter('app.pictures.users.directory'),
                    $newFilename
                );
            }
            else{
                $file->move(
                    $this->getParameter('app.pictures.directory'),
                    $newFilename
                );
            }
            
            
        } catch (FileException $e) {
            $this->addFlash('error', "L'image ne s'est pas enregistrée.");
        }

        return $newFilename;    
    }

    public function updateUserProfilPicture(UploadedFile $file, User $user)
    {
        $newProfilPicture = $this->movePicture($file, $user);
        $user->setImage($newProfilPicture);
        $this->em->flush();
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

    public function updateThumbnail(Trick $trick, $thumbnail)
    {
        if($thumbnail)
        {
            $trickThumbnail = $this->em->getRepository(Media::class)->getThumbnail($trick);
            $newThumbnail = $this->movePicture($thumbnail);
            $trickThumbnail->setLink($newThumbnail);
        }
    }

    public function updatePictures(Trick $trick, array $pictures)
    {
        foreach($pictures as $key => $picture)
        {
            if($picture['picturefile'])
            {
                $newPicture = $this->movePicture($picture['picturefile']);
                $trick->getMedia()->toArray()[$key]->setLink($newPicture);
            }
        }
    }

    public function updateVideos(Trick $trick, $videos)
    {
        foreach($videos as $key => $video)
        {
            $newVideo = $videos[$key]['videoframe']->getData();
            if($newVideo != $trick->getMedia()->toArray()[$key]->getLink())
            {
                $trick->getMedia()->toArray()[$key]->setLink($newVideo);
            }
        }
    }
}