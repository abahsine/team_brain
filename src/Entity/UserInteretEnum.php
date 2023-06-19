<?php

namespace App\Entity;

enum UserInteretEnum: string
{
    case Site = "Site internet complexe";
    case Ecommerce = "Site e-commerce";
    case Logiciel = "Application de bureau ou programme logiciels";
    case Saas = "SAAS";
    case Mobile = "Application mobile";
    case Ia = "Intelligence artificielle";

    public static function choices(): array
    {
        return [
            UserInteretEnum::Site->value => UserInteretEnum::Site->name,
            UserInteretEnum::Ecommerce->value => UserInteretEnum::Ecommerce->name,
            UserInteretEnum::Logiciel->value => UserInteretEnum::Logiciel->name,
            UserInteretEnum::Saas->value => UserInteretEnum::Saas->name,
            UserInteretEnum::Mobile->value => UserInteretEnum::Mobile->name,
            UserInteretEnum::Ia->value => UserInteretEnum::Ia->name,
        ];
    }
}
