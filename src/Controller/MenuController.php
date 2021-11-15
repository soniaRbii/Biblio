<?php

namespace App\Controller;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MenuController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function menu( LivreRepository $livre)
    {  $livres= $livre->findAll();
       
        return $this->render('menu/index.html.twig', [
         'livres' =>$livres
        ]);
    }
}

