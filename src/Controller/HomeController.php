<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Article; 
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

        // Récupérer les 3 derniers articles
        $articles = $entityManager->getRepository(Article::class)->findBy([], ['publishedAt' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'recipes' => $recipes,
            'articles' => $articles, // Transmettre les articles au template
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
    public function blog(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les articles pour la page blog
        $articles = $entityManager->getRepository(Article::class)->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('home/blog.html.twig', [
            'articles' => $articles, 
        ]);
    }
    
#[Route('/about', name: 'app_about')]
public function about(): Response
{
    return $this->render('home/about.html.twig');
}
}