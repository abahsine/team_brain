<?php

namespace App\Entity;

enum SkillTypeEnum: string
{
    case Backend = 'Backend';
    case Frontend = 'Frontend';
    case Fullstack = 'Full Stack';

    public static function choices(): array
    {
        return [
            SkillTypeEnum::Fullstack->value => SkillTypeEnum::Fullstack->name,
            SkillTypeEnum::Backend->value => SkillTypeEnum::Backend->name,
            SkillTypeEnum::Frontend->value => SkillTypeEnum::Frontend->name,
        ];
    }

}
