<?php

namespace App\Entity;

enum FrameworkEnum: string
{

    case Laravel = "Laravel";
    case Vuejs = "VueJs";
    case Symfony = "Symfony";
    case React = "React";
    case Wordpress = "Wordpress";

    public static function choices(): array
    {
        return [
            FrameworkEnum::Laravel->value => FrameworkEnum::Laravel->name,
            FrameworkEnum::Vuejs->value => FrameworkEnum::Vuejs->name,
            FrameworkEnum::Symfony->value => FrameworkEnum::Symfony->name,
            FrameworkEnum::React->value => FrameworkEnum::React->name,
            FrameworkEnum::Wordpress->value => FrameworkEnum::Wordpress->name,
        ];
    }
}
