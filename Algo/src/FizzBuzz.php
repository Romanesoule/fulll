<?php

class FizzBuzz
{
    private int $start;
    private int $end;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    private function isFizz(int $number): bool {
        return $number % 3 === 0;
    }

    private function isBuzz(int $number): bool {
        return $number % 5 === 0;
    }

    private function getResult(int $number): int|string
    {

        if ($this->isFizz($number) && $this->isBuzz($number)) {
            return 'FizzBuzz';
        }
        if ($this->isFizz($number)) {
            return 'Buzz';
        }

        if ($this->isBuzz($number)) {
            return 'Buzz';
        }

        return $number;

    }

    public function run(): void
    {
        for ($i = $this->start; $i <= $this->end; $i++) {

            $result = $this->getResult($i);
            echo $result . PHP_EOL;
        }
    }
}