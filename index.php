#!/usr/bin/env php
<?php

use App\Commands\AddCommand;
use App\Commands\DeleteCommand;
use App\Commands\ListCommand;
use App\Commands\SummaryCommand;
use Symfony\Component\Console\Application;

if (file_exists(__DIR__ . '/../../autoload.php')) {
    require __DIR__ . '/../../autoload.php';
} else {
    require __DIR__ . '/vendor/autoload.php';
}

/**
 * Start the console application.
 */
$app = new Application('Expense Tracker', '1.0.0');
//$app->setDefaultCommand("hello");

$app->add(new AddCommand());
$app->add(new ListCommand());
$app->add(new SummaryCommand());
$app->add(new DeleteCommand());

$app->run();
