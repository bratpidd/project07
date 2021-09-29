<?php
namespace App\Services;


use App\Blog\BlogPost;
use App\Blog\PostQueryBuilder;
use App\PropelModels\Post;
use App\PropelModels\PostQuery;
use App\PropelModels\TagQuery;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostService implements PostServiceInterface {

    public function getPost(int $postId) {
        $postQueryBuilder = new PostQueryBuilder();
        $post = $postQueryBuilder->getPostById($postId);

        return $post;
    }

    public function createPost(string $message, array $tags) {
        $postQueryBuilder = new PostQueryBuilder();
        $newBlogPost = new BlogPost($message, $tags);
        $postQueryBuilder->createPost($newBlogPost);
        // dd("Regular service was called! , " . $message);
    }

}