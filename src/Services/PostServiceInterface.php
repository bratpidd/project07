<?php
namespace App\Services;

interface PostServiceInterface {
    public function createPost(string $message, array $tags);
}