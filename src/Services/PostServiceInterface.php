<?php
namespace App\Services;

use App\Blog\BlogPost;
use App\Blog\BlogPostComment;
use App\Blog\SearchCriteria;

interface PostServiceInterface {
    public function createPost(string $message, array $tags);
    public function updatePost(BlogPost $blogPost);
    public function getPost(int $postId): BlogPost;
    public function getPosts(SearchCriteria $criteria): array;
    public function importPosts(string $json);
    public function createPostComment(BlogPostComment $comment);

    /**
     * @param $postId
     * @return BlogPostComment[]
     */
    public function getPostComments(int $postId): array;
}