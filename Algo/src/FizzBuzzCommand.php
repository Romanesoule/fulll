<?php


class FizzBuzzCommand
{
    const MAX_RANGE = 10000;

    /**
     * @throws InvalidArgumentsException
     */
    public function validateArguments(array $argv): array
    {
        if (count($argv) < 3) {
            throw new InvalidArgumentsException(FizzBuzzError::getMessage('missing_arguments'));
        }

        if (!ctype_digit($argv[1]) || !ctype_digit($argv[2])) {
            throw new InvalidArgumentsException(FizzBuzzError::getMessage('invalid_not_integers'));
        }

        $start = intval($argv[1]);
        $end = intval($argv[2]);

        if ($start > $end) {
            throw new InvalidArgumentsException(FizzBuzzError::getMessage('start_superior_to_end'));
        }

        if (($end - $start) > self::MAX_RANGE) {
            throw new InvalidArgumentsException(FizzBuzzError::getMessage('too_large'));
        }

        return [$start, $end];
    }

    public function process(array $argv): void
    {
        try {
            [$start, $end] = $this->validateArguments($argv);

            $fizzBuzz = new FizzBuzz($start, $end);
            $fizzBuzz->run();
        } catch (\InvalidArgumentsException $exception) {
            echo "Erreur : " . $exception->getMessage() . PHP_EOL;
            echo "Veuillez réessayer avec deux entiers ex : php bin/fizzbuzz.php 1 100" . PHP_EOL;
        }
    }
}