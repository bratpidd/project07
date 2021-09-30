<?php
namespace App\Services;

use App\Blog\BlogPost;
use App\Blog\BlogPostComment;
use App\Blog\SearchCriteria;
use App\PropelModels\PostQuery;

class PostServiceMock implements PostServiceInterface {

    public function createPost(string $message, array $tags) {
        dd("Mock Service was called! " . $message);
    }

    public function getPost(int $postId): BlogPost {
        return new BlogPost();
    }

    public function importPosts(string $json)
    {
        // TODO: Implement importPosts() method.
    }

    public function getPosts(SearchCriteria $criteria): array
    {
        // TODO: Implement getPosts() method.
    }

    public function createPostComment(BlogPostComment $comment)
    {
        // TODO: Implement createPostComment() method.
    }

    public function getPostComments(int $postId): array
    {
        // TODO: Implement getPostComments() method.
    }

    public function updatePost(BlogPost $blogPost)
    {
        // TODO: Implement updatePost() method.
    }
}