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
            $author = trim($_POST['author']);
            $message = trim($_POST['message']);

            $comment_manager = new DB('comments');
            $output = [
                'status' => true,
                'author' => $author,
                'message' => $message,
                'id' => $comment_manager->addEntry([
                    'author' => $author,
                    'message' => $message
                ])
            ];
        }
    }
    elseif ($_GET['name'] === 'update-comment') {
        if (
            isset($_POST['id']) && is_string($_POST['id']) &&
            isset($_POST['author']) && is_string($_POST['author']) &&
            isset($_POST['message']) && is_string($_POST['message'])
        ) {
            $id = (int) $_POST['id'];
            $author = trim($_POST['author']);
            $message = trim($_POST['message']);

            $comment_manager = new DB('comments');
            $output = [
                'status' => true,
                'id' => $id,
                'comment' => $comment_manager->updateEntry($id, [
                    'author' => $author,
                    'message' => $message
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
    elseif ($_GET['name'] === 'get-comment') {
        if (isset($_POST['id']) && is_string($_POST['id'])) {
            $comment_manager = new DB('comments');
            $id = (int) $_POST['id'];
            $output = [
                'status' => true,
                'comment' => $comment_manager->getEntry($id)
            ];
        }
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);