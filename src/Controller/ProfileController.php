<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function viewProfile(EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        /** @var User $user */
        $user = $this->getUser();

        // Récupérer les recettes de l'utilisateur
        $recipes = $entityManager->getRepository('App\Entity\Recipe')->findBy(['user' => $user]);

        return $this->render('home/profil.html.twig', [
            'user' => $user,
            'recipes' => $recipes,
            
        ]);
    }

    #[Route('/profile/edit', name: 'profile_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfile(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Récupérer l'utilisateur connecté
        /** @var User $user */
        $user = $this->getUser();

        // Créer le formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Traiter le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer la photo de profil
            /** @var UploadedFile $picture */
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $newFilename = uniqid().'.'.$picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('profile_pictures_directory'),
                        $newFilename
                    );
                    $user->setPicture($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de la photo de profil.');
                }
            }

            // Gérer le mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            // Enregistrer les changements
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('profile');
        }

        // Afficher le formulaire
        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
