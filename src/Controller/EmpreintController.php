<?php

namespace App\Controller;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Livre;
use App\Entity\Empreint;
use App\Repository\EmpreintRepository;
use App\Repository\LivreRepository;
use Symfony\Component\Security\Core\Security;
class EmpreintController extends AbstractController
{
    /**
     * @Route("/empreint", name="empreint")
     */
    public function index( EmpreintRepository $empreintRepo, Request $request)

    {
        $empreints = $empreintRepo->findBy(
            ['username' => $request->getSession()->get(Security::LAST_USERNAME)]
        );

        return $this->render('empreint/index.html.twig', [
            'empreints' => $empreints
        ]);
    }

        /**
     * @Route("/empreinter/{id}", name="empreinter")
     */
    public function empreinter(Livre $livre, Request $request ,  LivreRepository $rep){
        dump($livre);
       $user= $request->getSession()->get(Security::LAST_USERNAME);
$datetime =new \DateTime('now') ;
$dateNow =new \DateTime('now') ;
$date =$dateNow->modify('+15 Day');


        $empreint=new Empreint();
        $empreint->setUsername($user);
        $empreint->setIdLivre($livre->getId());
        $empreint->setDateEmpreint($datetime);
        $empreint->setDateRetour($date );
        $empreint->setStatus('en attente');
       
       
        $rep->setQuantity($livre->getQteStock()-1, $livre->getId());
     
        if($livre->getQteStock()==0){ 
            $this->addFlash('empreint', $empreint->getUsername() . ' ' ."le livre n'est pas disponible pour le moment ");}
            else{ $em=$this->getDoctrine()->getManager();
                $em->persist($empreint);
                $em->flush();
        $this->addFlash('empreint', $empreint->getUsername() . ' ' .'votre empreint est faite avec succes');
            }
        return $this->redirect($this->generateUrl('menu'));

    }
       

    }

