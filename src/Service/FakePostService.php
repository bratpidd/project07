<?php
namespace App\Service;

use App\Util\PostServiceInterface;

class FakePostService implements PostServiceInterface {

    public function addPost(string $message) {
        dd("Zdrastite, eto poddelnyj servis! " . $message);
    }

}