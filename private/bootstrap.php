<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_SERVER_NAME', 'localhost');
define('DB_NAME', 'bootcamp31');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');


spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});