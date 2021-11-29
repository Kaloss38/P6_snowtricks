<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Media;
use App\Entity\Trick;
use App\Form\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donner à votre trick ?',
                'attr' => [
                    'placeholder' => 'Nommez votre trick'
                ]
            ])
            ->add('relatedGroup', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Flip' => 'Flip',
                    'Grab' => 'Grab',
                    'Old School' => 'Old School',
                    'Rotation' => 'Rotation',
                ]
            ])
            // ->add('relatedGroup', EntityType::class, [
            //     'class' => Group::class,
            //     'choice_label' => 'name',
            //     'label' => 'Groupe'
            // ])
            ->add('thumbnail', FileType::class, [
                'label' => 'Choisissez votre image à la une',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Les images doivent être au formation .jpg ou .png'
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Ajoutez une description à votre trick',
                'attr' => [
                    'placeholder' => 'Votre description...'
                ]    
            ])
            ->add('medias', CollectionType::class,[
                'label' => 'Ajoutez une ou des photos à la gallerie',
                'entry_type' =>  PictureType::class,
                'mapped' => false,
                'by_reference' => false,
                'allow_add' => true
            ])
            ->add('videos', CollectionType::class,[
                'label' => 'Ajoutez un lien youtube',
                'entry_type' => VideoType::class,
                'mapped' => false,
                'by_reference' => false,
                'allow_add' => true
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
