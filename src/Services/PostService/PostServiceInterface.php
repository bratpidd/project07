<?php
namespace App\Services\PostService;


use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;

interface PostServiceInterface {
    public function createPost(string $message, array $tags);
    public function updatePost(PostTransferObject $blogPost);
    public function getPost(int $postId): PostTransferObject;
    public function getPosts(SearchCriteria $criteria): array;
    public function importPosts(string $json);
    public function createPostComment(PostCommentTransferObject $comment);

    /**
     * @return PostCommentTransferObject[]
     */
    public function getPostComments(int $postId): array;
}