<?php
namespace App\Service;

use App\Util\PostServiceInterface;

class PostService implements PostServiceInterface {

    public function addPost(string $message) {
        dd("presenting your message: , " . $message);
    }

}