<?php
namespace App\Services;


use App\Blog\BlogPost;
use App\Blog\BlogPostComment;
use App\Blog\PostQueryBuilder;
use App\Blog\SearchCriteria;
use App\PropelModels\Post;
use App\PropelModels\PostQuery;
use App\PropelModels\TagQuery;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostService implements PostServiceInterface {

    public function getPost(int $postId): BlogPost {
        $postQueryBuilder = new PostQueryBuilder();
        $post = $postQueryBuilder->getPostById($postId);

        return $post;
    }

    public function createPost(string $message, array $tags) {
        $postQueryBuilder = new PostQueryBuilder();
        $newBlogPost = new BlogPost($message, $tags);
        $postQueryBuilder->savePost($newBlogPost);
    }

    public function updatePost(BlogPost $blogPost) {
        $postQueryBuilder = new PostQueryBuilder();
        $postQueryBuilder->savePost($blogPost);
    }

    public function getPosts(SearchCriteria $criteria): array {
        $postQueryBuilder = new PostQueryBuilder();
        return $postQueryBuilder->getPostsByCriteria($criteria);
    }

    public function importPosts(string $json) {
        $fileContent = json_decode($json);
        foreach ($fileContent as $post) {
            $this->createPost($post->message, $post->tags);
        }
    }

    public function createPostComment(BlogPostComment $comment)
    {
        $postQueryBuilder = new PostQueryBuilder();
        $postQueryBuilder->createPostComment($comment);
    }

    /**
     * @param int $postId
     * @return BlogPostComment[]
     */
    public function getPostComments(int $postId): array {
        return PostQueryBuilder::getPostComments($postId);
    }
}