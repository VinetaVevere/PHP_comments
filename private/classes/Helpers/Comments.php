<?php

namespace Helpers;

use Storage\DB;

class Comments
{
    private $db_comments;
    public function __construct() {
        $this->db_comments = new DB('comments');
    }

    public function getAll() {
        return [
            'status' => true,
            'comments' => $this->db_comments->getAll()
        ];
    }

    public function get() {
        if (isset($_POST['id']) && is_string($_POST['id'])) {
            $id = (int) $_POST['id'];
            return [
                'status' => true,
                'comment' => $this->db_comments->getEntry($id)
            ];
        }
    }

    public function add() {
        if (
            isset($_POST['author']) && is_string($_POST['author']) &&
            isset($_POST['message']) && is_string($_POST['message'])
        ) {
            $author = trim($_POST['author']);
            $message = trim($_POST['message']);

            return [
                'status' => true,
                'author' => $author,
                'message' => $message,
                'id' => $this->db_comments->addEntry([
                    'author' => $author,
                    'message' => $message
                ])
            ];
        }
    }

    public function update() {
        if (
            isset($_POST['id']) && is_string($_POST['id']) &&
            isset($_POST['author']) && is_string($_POST['author']) &&
            isset($_POST['message']) && is_string($_POST['message'])
        ) {
            $id = (int) $_POST['id'];
            $author = trim($_POST['author']);
            $message = trim($_POST['message']);

            return [
                'status' => true,
                'id' => $id,
                'comment' => $this->db_comments->updateEntry($id, [
                    'author' => $author,
                    'message' => $message
                ])
            ];
        }
    }

    public function delete() {
        if (isset($_POST['id']) && is_string($_POST['id'])) {
            $id = (int) $_POST['id'];

            return [
                'status' => $this->db_comments->deleteEntry($id),
                'id' => $id,
            ];
        }
    }

}