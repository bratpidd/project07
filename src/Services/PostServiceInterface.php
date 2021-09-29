<?php
namespace App\Services;

interface PostServiceInterface {
    public function createPost(string $message, array $tags);
    public function getPost(int $postId);
}