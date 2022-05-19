<?php

include __DIR__ . '/../private/bootstrap.php';

use Storage\DB;
use Helpers\Comments;

header('Content-Type: application/json');
$output = ['status' => false];
if (isset($_GET['name']) && is_string($_GET['name'])) {
    $comment_helper = new Comments();
    $api_name = ['add-comment', 'update-comment', 'getAll-comment', 'delete-comment', 'get-comment'];

    if (array_key_exists($_GET['name'], array_flip($api_name))) {
        $arr = explode('-', $_GET['name']);
        $output = $comment_helper->{$arr[0]}();
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);