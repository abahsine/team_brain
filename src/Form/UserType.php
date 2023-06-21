<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\User;
use App\Entity\UserInteretEnum;
use App\Entity\UserNiveauEnum;
use App\Entity\UserTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        /** @var User $user */
        $user = $builder->getData();
        $builder
            ->add('email', EmailType::class, ['attr' => ['readonly' => 'readonly'], 'required' => true]);

        if ($user->getType() != UserTypeEnum::Unknown->value) {
            $builder->add('type', ChoiceType::class, [
                'label' => 'Vous êtes',
                'choices' => UserTypeEnum::choices(),
                'label_attr' => ['class' => 'fw-bold'],
                'disabled' => true,
            ]);
        } else {
            $builder->add('type', ChoiceType::class, [
                'label' => 'Vous êtes',
                'choices' => UserTypeEnum::choices(),
                'label_attr' => ['class' => 'fw-bold'],
                'required' => true
            ]);
        }

        $builder->add('username', TextType::class, ["required" => false, 'help' => 'Choisissez un username pour cacher votre prénom ou votre email sur les projets.'])
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone', TelType::class)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('skills', EntityType::class, [
                'label' => "Compétences",
                "class" => Skill::class,
                'choice_label' => 'tag',
                'multiple' => true,
                "expanded" => false,
                "by_reference" => false,
                "mapped" => true,
                "required" => true,
                "attr" => ["class" => "js-example-basic-single", "style" => "width:100%;"]
            ])
            ->add('niveau', ChoiceType::class, [
                'choices' => UserNiveauEnum::choices(),
                "required" => true,
            ])
            ->add('interets', ChoiceType::class, [
                'label' => 'Préférences',
                'choices' => UserInteretEnum::choices(),
                "required" => true,
                'multiple' => true,
                'expanded' => false,
                "attr" => ["class" => "js-example-basic-single", "style" => "width:100%;"]
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
