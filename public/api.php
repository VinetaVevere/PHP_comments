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
    elseif ($_GET['name'] == 'upload-image') {
        if (
            isset($_POST['author']) && is_string($_POST['author']) &&
            !empty($_FILES) && isset($_FILES['upload_image'])
        ) {
            $image_arr = $_FILES['upload_image'];
            if ($image_arr['error'] == 0) {

                $author = trim($_POST['author']);

                $db_image_manager = new DB('images');
                $id = $db_image_manager->addEntry([
                    'author' => $author,
                    'file_name' => explode('.', $image_arr['name'])[0]
                ]);

                if ($id != false) {
                    $file_content = file_get_contents($image_arr['tmp_name']);
                    file_put_contents(UPLOAD_DIR . "image_$id.png", $file_content);

                    $output = [
                        'status' => true,
                        'file_name' => $image_arr['name'],
                        'id' => $id
                    ];
                }
                else {
                    $output = [
                        'status' => false,
                        'error_msg' => $db_image_manager->getError()
                    ];
                }
            }
        }

    }
    elseif ($_GET['name'] == 'getAll-image') {
        $db_image_manager = new DB('images');

        $all_images = $db_image_manager->getAll();

        if ($all_images != false) {
            $output = [
                'status' => true,
                'images' => $all_images
            ];
        }
        else {
            $output = [
                'status' => false,
                'error_msg' => $db_image_manager->getError()
            ];
        }

    }
}

echo json_encode($output, JSON_PRETTY_PRINT);