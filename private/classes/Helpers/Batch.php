<?php
namespace Helpers;

class Batch
{
    private $images;
    private $comments;
    public function __construct() {
        $this->images = new Images();
        $this->comments = new Comments();
    }

    public function getAll() {
        $all_images = $this->images->getAll();
        if (!$all_images['status']) {
            return ['status' => false];
        }

        $all_comments = $this->comments->getAll();
        if (!$all_comments['status']) {
            return ['status' => false];
        }

        $output = array_merge($all_images, $all_comments);
    }
}

