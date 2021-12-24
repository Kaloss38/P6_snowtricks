<?php

namespace App\Services;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class Pagination{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function paginateComments(Request $request , $trick, $limit)
    {
        if(count($trick->getComments()) == 0)
        {
            return;
        }

        //On récupère le numéro de page
        $page = (int) $request->get("page", 1);
        
        //If page > totalPages
        if($page === 0){
            $page = 1;
            $comments = $this->em->getRepository(Comment::class)->getPaginatedComments($trick, $page, $limit);
        }
        
        $totalComments = count($trick->getComments());
        $totalPages = (int) ceil($totalComments / $limit);

        //If page > totalPages
        if($page > $totalPages){
            $page = $totalPages;
            $comments = $this->em->getRepository(Comment::class)->getPaginatedComments($trick, $page, $limit);
        }
        
        $comments = $this->em->getRepository(Comment::class)->getPaginatedComments($trick, $page, $limit);
        
        if(!$comments)
        {
            return;
        }
        
        return [
            "comments" => $comments,
            "page" => $page,
            "totalComments" => $totalComments,
            "limit" => $limit
        ];
    }
}