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
        //a mettre dans un service
        //On récupère le numéro de page
        $page = (int) $request->get("page", 1);
        // on récupère les commentaire de la page
        $comments = $this->em->getRepository(Comment::class)->getPaginatedComments($trick, $page, $limit);
        //on récupère le nombre total de commentaires
        $totalComments = count($trick->getComments());

        return [
            "comments" => $comments,
            "page" => $page,
            "totalComments" => $totalComments,
            "limit" => $limit
        ];
    }
}