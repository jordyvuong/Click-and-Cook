<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Cuisine;
use App\Entity\Ingredient;
use App\Entity\Instruction;
use App\Entity\Recipe;
use App\Form\RecipeType;
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
        $recipe = new Recipe();

        // Création du formulaire
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de la catégorie
            $category = $form->get('category')->getData();
            if ($category instanceof Category) {
                $recipe->setCategory($category);
            }

            // Gestion de la cuisine
            $cuisine = $form->get('cuisine')->getData();
            if ($cuisine instanceof Cuisine) {
                $recipe->setCuisine($cuisine);
            }

            // Gestion de l'upload de l'image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('recipes_images_directory'), // Configurez ce paramètre dans services.yaml
                        $newFilename
                    );
                    $recipe->setImage($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'An error occurred while uploading the image.');
                }
            }

            // Lien entre les ingrédients et la recette
            foreach ($recipe->getIngredients() as $ingredient) {
                $ingredient->setRecipe($recipe);
            }

            // Lien entre les instructions et la recette
            foreach ($recipe->getInstructions() as $instruction) {
                $instruction->setRecipe($recipe);
            }

            // Enregistrement dans la base de données
            $entityManager->persist($recipe);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Recipe successfully added!');

            return $this->redirectToRoute('recipe_list'); // Redirection vers la liste des recettes
        }

        return $this->render('recipe/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe', name: 'recipe_list')]
    public function listRecipes(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les recettes
        $recipes = $entityManager->getRepository(Recipe::class)->findAll();

        return $this->render('recipe/list.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/recipe/{id}', name: 'recipe_view', requirements: ['id' => '\d+'])]
    public function viewRecipe(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer une recette par son ID
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found.');
        }

        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipe,
        ]);
    }
    #[Route('/recipe/{id}', name: 'recipe_detail', requirements: ['id' => '\d+'])]
    public function recipeDetail(int $id, EntityManagerInterface $entityManager): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);
    
        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found.');
        }
    
        return $this->render('recipe/detail.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
