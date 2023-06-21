<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Entity\UserInteretEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class ProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Projet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Projet')
            ->setEntityLabelInPlural('Projets')// ->setEntityPermission('ROLE_ADMIN')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('createdAt')
                ->hideOnForm(),
            Field::new('updatedAt')
                ->hideOnForm(),
            TextField::new('titre'),
            ImageField::new('image')
                ->setUploadDir('/public/uploads/projets/')
                ->setBasePath('/uploads/projets/')
                ->setLabel('Image'),
            AssociationField::new('Owner')
                ->autocomplete(),
            TextEditorField::new('description'),
            ChoiceField::new('type')
                ->setChoices(UserInteretEnum::cases())
                ->setColumns(4),
            AssociationField::new('skills')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
            AssociationField::new('inscriptions')
                ->hideOnForm(),
        ];
    }

}
