<?php
namespace App\Services;

class PostServiceMock implements PostServiceInterface {

    public function addPost(string $message) {
        dd("Zdrastite, eto poddelnyj servis! " . $message);
    }

}