<?php

require_once __DIR__ . '/Autoloader.php';

Core\Autoload\Autoloader::addNamespace('Core', dirname(__DIR__));
Core\Autoload\Autoloader::register();
