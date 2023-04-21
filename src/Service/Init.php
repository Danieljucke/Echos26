<?php

namespace App\Service;

use App\Entity\Commentaire;

final class Init
{
    public static function service()
    {
        return [
            'commentaireService'=>new Commentaire()
        ];
    }
}