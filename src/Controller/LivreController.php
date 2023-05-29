<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(LivreRepository $livreRepository): Response
    {
        // on récupère tous les livres 
        $livres = $livreRepository->findAll();
        return $this->render('livre/index.html.twig', [
            'livres'=>$livres,

        ]);
    }
}
