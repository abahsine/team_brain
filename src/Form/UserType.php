<?php

namespace App\Form;

use App\Entity\FrameworkEnum;
use App\Entity\Skill;
use App\Entity\SkillTypeEnum;
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
                'required' => true,
            ])
            ->add('skills', EntityType::class, [
                "class" => Skill::class,
                'choice_label' => 'tag',
                'multiple' => true,
                "expanded" => false,
                "by_reference" => false,
                "mapped" => true,
                "attr" => ["class" => "js-example-basic-single", "style" => "width:100%;"]
            ])
            ->add('niveau', ChoiceType::class, [
                'choices' => UserNiveauEnum::choices(),
            ])
            ->add('preference', ChoiceType::class, [
                'choices' => SkillTypeEnum::choices(),
            ])
            ->add('interets', ChoiceType::class, [
                'choices' => UserInteretEnum::choices(),
                'multiple' => true,
                'expanded' => false,
                "attr" => ["class" => "js-example-basic-single", "style" => "width:100%;"]
            ])
            ->add('frameworks', ChoiceType::class, [
                'choices' => FrameworkEnum::choices(),
                'label' => 'Frameworks et CMS',
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
