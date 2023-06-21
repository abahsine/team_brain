<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Skill;
use App\Entity\UserInteretEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', HiddenType::class)
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'label' => 'Fin du projet',
                'help' => 'Deadline à respecter (facultatif) '
            ])
            ->add('image', FileType::class, [
                "required" => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Uploader une image de type jpg ou png',
                    ])
                ],
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'label' => 'Compétences recherchés',
                'multiple' => true,
                "attr" => ["class" => "js-example-basic-single", "style" => "width:100%;"]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de projet',
                'choices' => UserInteretEnum::choices(),
                "required" => true,
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
