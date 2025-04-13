#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/FizzBuzzCommand.php';
require_once __DIR__ . '/../src/FizzBuzz.php';

$command = new FizzBuzzCommand();
$command->process($argv);