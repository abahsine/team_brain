<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use App\Entity\SkillTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('tag'),
            TextEditorField::new('description'),
            ChoiceField::new('type')->setChoices(SkillTypeEnum::cases())->renderAsBadges(
                [SkillTypeEnum::Backend->value => 'success', SkillTypeEnum::Frontend->value => 'danger']
            ),
        ];
    }
}
