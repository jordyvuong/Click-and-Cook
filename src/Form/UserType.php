<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false, // Indique que ce champ n'est pas directement lié à l'entité
                'required' => false, // Le rendre optionnel
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false, // Indique que ce champ n'est pas directement lié à l'entité
                'required' => false, // L'utilisateur n'est pas obligé de changer son mot de passe
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
