<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('isVerified')
            ->add('googleId')
            ->add('type')
            ->add('username')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone')
            ->add('dateNaissance')
            ->add('createdAt')
            ->add('nom')
            ->add('prenom')
            ->add('skill')
            ->add('projet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
