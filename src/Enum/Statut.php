<?php

namespace App\Enum;

final class Statut
{
    const ACTIF = 'Non Solde';
    const INACTIF = 'Solde';

    public static function getValues(): array
    {
        return [
            self::ACTIF,
            self::INACTIF,
        ];
    }
}