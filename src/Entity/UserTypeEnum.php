<?php

namespace App\Entity;

enum UserTypeEnum: string
{
    case Entrepreneur = 'Entrepreneur';
    case Etudiant = 'Etudiant';
    case Unknown = '';

    public static function array(): array
    {
        return [
            UserTypeEnum::Unknown->value => UserTypeEnum::Unknown->name,
            UserTypeEnum::Etudiant->value => UserTypeEnum::Etudiant->name,
            UserTypeEnum::Entrepreneur->value => UserTypeEnum::Entrepreneur->name,
        ];
    }

    public static function choices(): array
    {
        return [
            UserTypeEnum::Etudiant->value => UserTypeEnum::Etudiant->name,
            UserTypeEnum::Entrepreneur->value => UserTypeEnum::Entrepreneur->name,
        ];
    }
}