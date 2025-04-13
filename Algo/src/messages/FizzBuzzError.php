<?php

class FizzBuzzError
{
    const MESSAGES = [
        'missing_arguments' => "Paramètres manquants : début et fin attendus.",
        'invalid_not_integers' => "Les arguments doivent être des entiers positifs.",
        'start_superior_to_end' => "Le début doit être inférieur ou égal à la fin.",
        'too_large' => "Plage trop large. Limite dépassée",
    ];

    static public function getMessage(string $key): string
    {
        if (!isset(self::MESSAGES[$key])) {
            return 'Erreur inconnue...';
        }

        return self::MESSAGES[$key];
    }
}