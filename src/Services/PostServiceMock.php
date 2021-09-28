<?php
namespace App\Services;

class PostServiceMock implements PostServiceInterface {

    public function createPost(string $message, array $tags) {
        dd("Mock Service was called! " . $message);
    }

}