<?php

class FizzBuzzCommand
{
    public function isArgumentsValid(array $argv): bool
    {
        if (count($argv) < 3) {
            echo "Erreur : paramètres manquants (attendus : début fin)\n";
            return false;
        }

        if (!ctype_digit($argv[1]) || !ctype_digit($argv[2])) {
            echo "Erreur : paramètres invalides, des entiers positifs sont attendus." . PHP_EOL;
            return false;
        }

        $start = intval($argv[1]);
        $end = intval($argv[2]);

        if ($start <= 0) {
            echo "Erreur : paramètre invalide, le début doit être supérieur à 0." . PHP_EOL;
            return false;
        }

        if ($start > $end) {
            echo "Erreur : paramètre invalide, le début doit être inférieur ou égal à la fin." . PHP_EOL;
            return false;
        }

        return true;
    }

    public function process(array $argv): void
    {
        if (!$this->isArgumentsValid($argv)) {
            echo "Veuillez réessayer avec deux entiers ex : php fizzbuzz.php 1 100" . PHP_EOL;
            return;
        }

        $start = intval($argv[1]);
        $end = intval($argv[2]);

        $fizzBuzz = new FizzBuzz($start, $end);
        $fizzBuzz->run();
    }
}