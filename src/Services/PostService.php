<?php
namespace App\Services;


use Propel\Runtime\Exception\PropelException;

class PostService implements PostServiceInterface {

    public function addPost(string $message) {
        dd("Regular service was called! , " . $message);
    }

}