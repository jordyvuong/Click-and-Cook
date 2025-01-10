<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * Liste des articles de blog
     */
    #[Route('/blog', name: 'blog_list')]
    public function listArticles(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les articles, triés par date de publication
        $articles = $entityManager->getRepository(Article::class)->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('blog/blog.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Affichage détaillé d'un article
     */
    #[Route('/blog/{id}', name: 'blog_detail', requirements: ['id' => '\d+'])]
    public function viewArticle(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'article par son ID
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        return $this->render('blog/detail.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * Ajouter un nouvel article (réservé aux administrateurs)
     */
    #[Route('/blog/add', name: 'blog_add')]
    public function addArticle(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifier que seul l'administrateur peut ajouter un article
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous devez être administrateur pour ajouter un article.');
            return $this->redirectToRoute('blog_list');
        }

        // Créer un nouvel article
        $article = new Article();
        $article->setAuthor($this->getUser()); // Définir l'auteur comme l'utilisateur connecté
        $article->setPublishedAt(new \DateTime()); // Date de publication automatique

        // Générer le formulaire
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, sauvegarder l'article
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload d'image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('articles_images_directory'), // Paramètre défini dans services.yaml
                        $newFilename
                    );
                    $article->setImage($newFilename); // Associer le nom du fichier à l'article
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de l\'image.');
                }
            }

            // Sauvegarder l'article
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article ajouté avec succès.');
            return $this->redirectToRoute('blog_list');
        }

        return $this->render('blog/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprimer un article (réservé aux administrateurs)
     */
    #[Route('/blog/delete/{id}', name: 'blog_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteArticle(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer l'article par son ID
        $article = $entityManager->getRepository(Article::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        // Vérifier que seul un administrateur peut supprimer l'article
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer cet article.');
            return $this->redirectToRoute('blog_list');
        }

        // Vérifier le token CSRF
        if (!$this->isCsrfTokenValid('delete_article_' . $article->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('blog_list');
        }

        // Supprimer l'article
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'Article supprimé avec succès.');
        return $this->redirectToRoute('blog_list');
    }
}
