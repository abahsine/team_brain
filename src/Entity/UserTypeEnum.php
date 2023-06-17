<?php

namespace App\Entity;

enum UserTypeEnum: string
{
    case Entrepreneur = 'entrepreneur';
    case Etudiant = 'etudiant';
    case Unknown = '';

    public static function array(): array
    {
        return [
            UserTypeEnum::Unknown->name => UserTypeEnum::Unknown->value,
            UserTypeEnum::Etudiant->name => UserTypeEnum::Etudiant->value,
            UserTypeEnum::Entrepreneur->name => UserTypeEnum::Entrepreneur->value,
        ];
    }

    public static function choices(): array
    {
        return [
            UserTypeEnum::Etudiant->name => UserTypeEnum::Etudiant->value,
            UserTypeEnum::Entrepreneur->name => UserTypeEnum::Entrepreneur->value,
        ];
    }
}