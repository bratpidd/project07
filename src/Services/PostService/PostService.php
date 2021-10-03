<?php
namespace App\Services\PostService;


use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;


class PostService implements PostServiceInterface {

    /**
     * @var PostServiceFactory
     */
    public $factory;

    /*public function __construct() {
        $this->factory = new PostServiceFactory();
    }*/

    public function getPost(int $postId): ?PostTransferObject {
        return $this->factory->getBlogRepository()->getPostById($postId);
    }

    /**
     * @param SearchCriteria $criteria
     * @return PostTransferObject[]
     */
    public function getPosts(SearchCriteria $criteria): array {
        return $this->factory->getBlogRepository()->getPostsByCriteria($criteria);
    }

    public function createPost(string $message, array $tags): void {
        $newBlogPost = new PostTransferObject($message, $tags);
        $this->factory->getPostQueryBuilder()->savePost($newBlogPost);
    }

    public function updatePost(PostTransferObject $blogPost): void {
        $this->factory->getPostQueryBuilder()->savePost($blogPost);
    }

    public function importPosts(string $json): void {
        $fileContent = json_decode($json);
        foreach ($fileContent as $post) {
            $this->createPost($post->message, $post->tags);
        }
    }

    public function createPostComment(PostCommentTransferObject $comment): void
    {
        $this->factory->getRabbitMqService()->sendRabbitMqMessage($comment->text);
        $this->factory->getPostQueryBuilder()->createPostComment($comment);
    }

    /**
     * @param int $postId
     * @return PostCommentTransferObject[]
     */
    public function getPostComments(int $postId): array {
        return $this->factory->getBlogRepository()->getPostComments($postId);
    }
}