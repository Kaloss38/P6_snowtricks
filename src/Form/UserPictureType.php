<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserPictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Les images doivent être au format .jpg ou .png'
                    ])
                ]
                
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier mon image'
            ])
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
