<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/livre')]
class AdminLivreController extends AbstractController
{
    #[Route('/', name: 'app_admin_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('admin_livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_livre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LivreRepository $livreRepository, SluggerInterface $slugger): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livre->setSlug(strtolower($slugger->slug($livre->getTitre())));
            $livre->setTitre(ucfirst($livre->getTitre()));
            $livreRepository->save($livre, true);

            // Mise en place d'un message flash. 
            // $this = objet de la classe elle même, il fait toujours référence à l'objet 
            // dont il est dans le code, si je suis dans un controller fait référence au controleur,
            //  si je suis dans un repository fait référence au repository
            $this->addFlash('success', 'La catégorie'.$livre->getTitre().'a bien été ajoutée.');

            return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('admin_livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_livre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livreRepository->save($livre, true);

            return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_livre_delete', methods: ['POST'])]
    public function delete(Request $request, Livre $livre, LivreRepository $livreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $livreRepository->remove($livre, true);
        }

        return $this->redirectToRoute('app_admin_livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
