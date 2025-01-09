<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les 3 dernières recettes
        $recipes = $entityManager->getRepository(Recipe::class)->findBy([], ['id' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profile(): Response
    {
        return $this->render('home/profil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
