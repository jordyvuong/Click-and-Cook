<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Cuisine;
use App\Entity\Recipe;
use App\Entity\Review;
use App\Form\RecipeType;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe/add', name: 'recipe_add')]
    public function addRecipe(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('info', 'Veuillez vous connecter pour ajouter une recette.');
            return $this->redirectToRoute('app_login', ['redirect_to' => 'recipe_add']);
        }

        $recipe = new Recipe();
        $recipe->setUser($this->getUser());

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('recipes_images_directory'), $newFilename);
                    $recipe->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }
            }

            $entityManager->persist($recipe);
            $entityManager->flush();

            $this->addFlash('success', 'Recette ajoutée avec succès !');
            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('recipe/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe', name: 'recipe_list')]
    public function listRecipes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cuisines = $entityManager->getRepository(Cuisine::class)->findAll();
        $categories = $entityManager->getRepository(Category::class)->findAll();

        // Gestion des filtres
        $cuisineFilter = $request->query->get('cuisine');
        $categoryFilter = $request->query->get('category');
        $criteria = [];

        if ($cuisineFilter) {
            if (is_numeric($cuisineFilter)) {
                $criteria['cuisine'] = $cuisineFilter;
            } else {
                $cuisine = $entityManager->getRepository(Cuisine::class)->findOneBy(['name' => $cuisineFilter]);
                if ($cuisine) {
                    $criteria['cuisine'] = $cuisine->getId();
                }
            }
        }

        if ($categoryFilter && is_numeric($categoryFilter)) {
            $criteria['category'] = $categoryFilter;
        }

        $recipes = $entityManager->getRepository(Recipe::class)->findBy($criteria);

        return $this->render('recipe/list.html.twig', [
            'recipes' => $recipes,
            'cuisines' => $cuisines,
            'categories' => $categories,
        ]);
    }

    #[Route('/recipe/edit/{id}', name: 'recipe_edit', requirements: ['id' => '\d+'])]
    public function editRecipe(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recette non trouvée.');
        }

        if ($recipe->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à modifier cette recette.');
            return $this->redirectToRoute('recipe_list');
        }

        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('recipes_images_directory'), $newFilename);
                    $recipe->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Recette modifiée avec succès !');
            return $this->redirectToRoute('recipe_view', ['id' => $recipe->getId()]);
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/{id}', name: 'recipe_view', requirements: ['id' => '\d+'])]
    public function viewRecipe(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recette non trouvée.');
        }

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setUser($this->getUser());
            $review->setRecipe($recipe);

            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Avis ajouté avec succès !');
            return $this->redirectToRoute('recipe_view', ['id' => $id]);
        }

        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipe,
            'reviewForm' => $form->createView(),
        ]);
    }

    #[Route('/recipe/delete/{id}', name: 'recipe_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteRecipe(int $id, EntityManagerInterface $entityManager): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recette non trouvée.');
        }

        if ($recipe->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer cette recette.');
            return $this->redirectToRoute('recipe_list');
        }

        foreach ($recipe->getReviews() as $review) {
            $entityManager->remove($review);
        }

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash('success', 'Recette supprimée avec succès !');
        return $this->redirectToRoute('recipe_list');
    }

    #[Route('/review/delete/{id}', name: 'review_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteReview(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = $entityManager->getRepository(Review::class)->find($id);

        if (!$review) {
            throw $this->createNotFoundException('Avis non trouvé.');
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer cet avis.');
            return $this->redirectToRoute('recipe_view', ['id' => $review->getRecipe()->getId()]);
        }

        $entityManager->remove($review);
        $entityManager->flush();

        $this->addFlash('success', 'Avis supprimé avec succès !');
        return $this->redirectToRoute('recipe_view', ['id' => $review->getRecipe()->getId()]);
    }
}
