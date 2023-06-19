<?php

namespace App\Entity;

enum UserNiveauEnum: string
{
    case Etudiant = "Etudiant (sans expérience professionnelle ou à travaillé sur des petits projets ou taches)";
    case Freelance = "Freelance ou stagiaire alternant junior (déjà travaillé sur des projets professionnels rémunéré ou non pour des clients ou une entreprise)";

    public static function choices(): array
    {
        return [
            UserNiveauEnum::Etudiant->value => UserNiveauEnum::Etudiant->name,
            UserNiveauEnum::Freelance->value => UserNiveauEnum::Freelance->name,
        ];
    }
}
