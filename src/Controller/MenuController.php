<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        
        return $this->render('menu/index.html.twig');
    }
     /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('menu/contact.html.twig' );
    }

    /**
     * @Route("/recettes", name="recettes")
     */
    public function recettes(MenuRepository $repo): Response
    {
        $menus = $repo->findAll();
     // dd($menus[0]->getUser()->getPseudo());
        //dd($menus);
        return $this->render('menu/recettes.html.twig', compact('menus'));
    }
}

