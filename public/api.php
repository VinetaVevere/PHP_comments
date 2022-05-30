<?php

include __DIR__ . '/../private/bootstrap.php';

use Helpers\Comments;
use Helpers\Images;
use Helpers\Batch;

header('Content-Type: application/json');
$output = ['status' => false];
if (
    isset($_GET['object']) && is_string($_GET['object']) &&
    isset($_GET['action']) && is_string($_GET['action'])
) {
    $object_name = $_GET['object'];
    $action_name = $_GET['action'];

    $supported_objects_and_actions = [
        'comment' => ['add', 'update', 'getAll', 'delete', 'get'],
        'image' => ['upload', 'getAll', 'delete'],
        'batch' => ['getAll']
    ];

    $helper_names = [
        'comment' => 'Comments',
        'image' => 'Images',
        'batch' => 'Batch'
    ];

    if (
        array_key_exists($object_name, $supported_objects_and_actions) &&
        in_array($action_name, $supported_objects_and_actions[$object_name])
    ) {
        $class_name = 'Helpers\\' . $helper_names[$object_name];
        $helper = new $class_name();
        $output = $helper->{$action_name}();
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);