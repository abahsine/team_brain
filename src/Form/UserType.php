<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['readonly' => 'readonly'], 'required' => true])
            ->add('type', ChoiceType::class, ['choices' => UserTypeEnum::choices(), 'label_attr' => ['class' => 'fw-bold']])
            ->add('username', TextType::class, ["required" => false, 'help' => 'Choisissez un username pour cacher votre email.'])
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone', TelType::class)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
            ])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('ville', TextType::class, ["required" => false])
            ->add('pays', TextType::class, ["required" => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
