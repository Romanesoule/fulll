#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/FizzBuzzCommand.php';
require_once __DIR__ . '/../src/FizzBuzz.php';
require_once __DIR__ . '/../src/messages/FizzBuzzError.php';
require_once __DIR__ . '/../src/Exception/InvalidArgumentsException.php';

$command = new FizzBuzzCommand();
$command->process($argv);