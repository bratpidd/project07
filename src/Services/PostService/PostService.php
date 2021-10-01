<?php
namespace App\Services\PostService;


use App\Services\PostService\Repository\BlogRepository;
use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;


class PostService implements PostServiceInterface {

    public function getPost(int $postId): PostTransferObject {
        $blogRepository = new BlogRepository();

        return $blogRepository->getPostById($postId);
    }

    /**
     * @param SearchCriteria $criteria
     * @return PostTransferObject[]
     */
    public function getPosts(SearchCriteria $criteria): array {
        $blogRepository = new BlogRepository();
        return $blogRepository->getPostsByCriteria($criteria);
    }

    public function createPost(string $message, array $tags) {
        $blogRepository = new BlogRepository();
        $newBlogPost = new PostTransferObject($message, $tags);
        $blogRepository->savePost($newBlogPost);
    }

    public function updatePost(PostTransferObject $blogPost) {
        $blogRepository = new BlogRepository();
        $blogRepository->savePost($blogPost);
    }

    public function importPosts(string $json) {
        $fileContent = json_decode($json);
        foreach ($fileContent as $post) {
            $this->createPost($post->message, $post->tags);
        }
    }

    public function createPostComment(PostCommentTransferObject $comment)
    {
        $blogRepository = new BlogRepository();
        $blogRepository->createPostComment($comment);
    }

    /**
     * @param int $postId
     * @return PostCommentTransferObject[]
     */
    public function getPostComments(int $postId): array {
        $blogRepository = new BlogRepository();
        return $blogRepository->getPostComments($postId);
    }
}