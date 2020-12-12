<?php

# Website config
require '../config/config.php';

# require Composer files
require_once '../vendor/autoload.php';

# autoload classes
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    include __DIR__ . '/modules/' . $classPath . '.php';
});
