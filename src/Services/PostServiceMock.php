<?php
namespace App\Services;

use App\PropelModels\PostQuery;

class PostServiceMock implements PostServiceInterface {

    public function createPost(string $message, array $tags) {
        dd("Mock Service was called! " . $message);
    }

    public function getPost(int $postId) {
        return "post mock";
    }

}