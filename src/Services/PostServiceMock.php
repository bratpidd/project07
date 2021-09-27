<?php
namespace App\Services;

class PostServiceMock implements PostServiceInterface {

    public function addPost(string $message) {
        dd("Mock Service was called! " . $message);
    }

}