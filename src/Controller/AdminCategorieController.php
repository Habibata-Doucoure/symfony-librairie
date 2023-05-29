<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categorie')]
class AdminCategorieController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('admin_categorie/index.html.twig', [
            'categories' => $categorieRepository->findBy([], ['id'=>'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_new', methods: ['GET', 'POST'])]
    // j'importe dans ma fonction les outils de la classe sluggerinterface
    public function new(Request $request, CategorieRepository $categorieRepository, SluggerInterface $slugger): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // permet la mise en place du slug :récupération du nom saisie dans le formulaire, conversion du nom en slug et je le mets en minuscule
            // strtolower c'est la minuscule
            $categorie->setSlug(strtolower($slugger->slug($categorie->getNom())));
            $categorie->setNom(ucfirst($categorie->getNom()));
            $categorieRepository->save($categorie, true);
            // Mise en place d'un message flash. 
            // $this = objet de la classe elle même, il fait toujours référence à l'objet 
            // dont il est dans le code, si je suis dans un controller fait référence au controleur,
            //  si je suis dans un repository fait référence au repository
            $this->addFlash('success', 'La catégorie'.$categorie->getNom().'a bien été ajoutée.');
            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('admin_categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieRepository->save($categorie, true);

            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, CategorieRepository $categorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $categorieRepository->remove($categorie, true);
        }

        return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
