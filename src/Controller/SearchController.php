<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\LivreRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, LivreRepository $repo)
    {
        $query = $request->request->get('form')['query'];
        if($query) {
            $livres = $repo->findArticlesByName($query);
        }
        return $this->render('menu/index.html.twig', [
            'livres' => $livres
        ]);
    }
    public function searchBar()
    { 
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control rounded',
                    'placeholder' => 'Search'
                ]
            ])
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-primary',
                    'color'=>  'steelblue'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
