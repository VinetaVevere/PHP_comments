<?php

define('DEBUG_MODE', true);
define('PRIVATE_DIR', __DIR__ . '/');
define('UPLOAD_DIR', PRIVATE_DIR . 'uploads/');

define('DB_SERVER_NAME', 'localhost');
define('DB_NAME', 'bootcamp31');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});