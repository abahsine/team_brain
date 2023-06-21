<?php

namespace App\Controller\Admin;

use App\Entity\Inscription;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class InscriptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Inscription::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('role'),
            AssociationField::new('projet')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
            AssociationField::new('user')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
        ];
    }
}
