<?php
namespace App\Services;

class PostService implements PostServiceInterface {

    public function addPost(string $message) {
        dd("presenting your message: , " . $message);
    }

}