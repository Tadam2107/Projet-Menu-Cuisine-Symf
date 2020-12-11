<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Form\RecetteFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuAdminController extends AbstractController
{
    /**
     * @Route("/admin/recettes", name="admin_recettes")
     */
    public function index(): Response
    {
        return $this->render('admin/recettes/index.html.twig');
    }

    /**
     *@Route("/admin/menu/{id}", name="admin_recette_edit", methods="GET|POST")
     *@Route("/admin/recette/ajout", name="admin_recette_ajout")
     */
    public function ajouterRecette(Menu $menu = null, Request $request, EntityManagerInterface $em): Response
    {
 
        $user = $this->getUser();

        if (!$menu) {
            $menu = new Menu();
           
            $menu->setUser($user);
            $menu->setCreatedAt(new \Datetime('now'));
          
        }

        //variable pour savoir si on est en création ou modif;
        $modif = $menu->getId() !== null;

        $form = $this->createForm(RecetteFormType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          //  dd($menu);
            $em->persist($menu);
            $em->flush();

            $this->addFlash('message', $modif ? 'Recette modifiée avec succès' : 'Recette ajoutée avec succès');

            return $this->redirectToRoute('admin_recettes');
        }

        return $this->render('admin/recettes/ajouterrecette.html.twig', ['formulaireRecette' => $form->createView()]);
}
}