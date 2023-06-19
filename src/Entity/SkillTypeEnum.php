<?php

namespace App\Entity;

enum SkillTypeEnum: string
{
    case Backend = 'Backend';
    case Frontend = 'Frontend';

    public static function choices(): array
    {
        return [
            SkillTypeEnum::Backend->value => SkillTypeEnum::Backend->name,
            SkillTypeEnum::Frontend->value => SkillTypeEnum::Frontend->name,
        ];
    }

}
