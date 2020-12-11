<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function index(): Response
    {
        return $this->render('admin/categorie/index.html.twig');
    }

    /**
     * @Route("/admin/categorie/ajout", name="admin_categorie_ajout")
     */
    public function ajouterCategorie(Categorie $categorie = null, Request $request, EntityManagerInterface $em): Response
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategoryFormType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
        }

        return $this->render('admin/categorie/ajoutercategorie.html.twig', ['formulaireCateg' => $form->createView()]);
    }
}
