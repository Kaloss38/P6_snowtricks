<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ReinitPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'label' => 'Votre mot de passe',
            'required' => true,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre mot de passe'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmez votre mot de passe',
                'attr' => [
                    'placeholder' => 'Merci confirmez votre mot de passe'
                ]
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => "S'inscrire"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
