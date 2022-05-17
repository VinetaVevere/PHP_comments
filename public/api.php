<?php

include __DIR__ . '/../private/bootstrap.php';

use Storage\DB;

header('Content-Type: application/json');
$output = ['status' => false];
if (isset($_GET['name']) && is_string($_GET['name'])) {
    if ($_GET['name'] === 'add-comment') {
        if (
            isset($_POST['author']) && is_string($_POST['author']) &&
            isset($_POST['message']) && is_string($_POST['message'])
        ) {
            $comment_manager = new DB('comments');
            $output = [
                'status' => true,
                'author' => $_POST['author'],
                'message' => $_POST['message'],
                'id' => $comment_manager->addEntry([
                    'author' => $_POST['author'],
                    'message' => $_POST['message']
                ])
            ];
        }
    }
    elseif ($_GET['name'] === 'get-comments') {
        $comment_manager = new DB('comments');
        $output = [
            'status' => true,
            'comments' => $comment_manager->getAll()
        ];
    }
    elseif ($_GET['name'] === 'delete-comment') {
        if (isset($_POST['id']) && is_string($_POST['id'])) {
            $comment_manager = new DB('comments');
            $id = (int) $_POST['id'];

            $output = [
                'status' => $comment_manager->deleteEntry($id),
                'id' => $id,
            ];
        }
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);