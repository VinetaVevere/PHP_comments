<?php

include __DIR__ . '/../private/bootstrap.php';

use Storage\DB;
use Helpers\Comments;

header('Content-Type: application/json');
$output = ['status' => false];
if (isset($_GET['name']) && is_string($_GET['name'])) {
    $comment_helper = new Comments();
    if ($_GET['name'] === 'add-comment') {
        $output = $comment_helper->add();
    }
    elseif ($_GET['name'] === 'update-comment') {
        $output = $comment_helper->update();
    }
    elseif ($_GET['name'] === 'get-comments') {
        $output = $comment_helper->getAll();
    }
    elseif ($_GET['name'] === 'delete-comment') {
        $output = $comment_helper->delete();
    }
    elseif ($_GET['name'] === 'get-comment') {
        $output = $comment_helper->get();
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);