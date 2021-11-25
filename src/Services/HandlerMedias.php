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

    public function __construct(SluggerInterface $slugger, EntityManagerInterface $em)
    {
        $this->slugger = $slugger;
    }

    public function addThumbnail(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        $media = new Media();
        try {
            $file->move(
                $this->getParameter('app.pictures.directory'),
                $newFilename
            );

            $media->setLink($newFilename);
            $media->setType('image');
            $media->setIsThumbnail(1);

        } catch (FileException $e) {
            $this->addFlash('error', "L'image ne s'est pas enregistrée.");
        }

        return $media;
    }

    private function moveFile()
    {

    }
}