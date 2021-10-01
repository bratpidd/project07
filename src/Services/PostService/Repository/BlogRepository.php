<?php

namespace App\Services\PostService\Repository;

use App\Services\PostService\Persistence\Propel\Comment;
use App\Services\PostService\Persistence\Propel\Post;
use App\Services\PostService\Persistence\Propel\PostQuery;
use App\Services\PostService\Persistence\Propel\TagQuery;
use App\Services\PostService\QueryBuilders\PostQueryBuilder;
use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;
use App\Services\PostService\TransferObjectsMappers\PostCommentEntityMapper;
use App\Services\PostService\TransferObjectsMappers\PostEntityMapper;
use Propel\Runtime\Collection\Collection;

class BlogRepository

{
    /**
     * @var PostQueryBuilder
     */
    private $postQueryBuilder;

    public function __construct() {
        $this->postQueryBuilder = new PostQueryBuilder();
    }

    /**
     * @param SearchCriteria $criteria
     * @return PostTransferObject[]
     */
    public function getPostsByCriteria(SearchCriteria $criteria): array {
        $postMapper = new PostEntityMapper();
        $qPosts = $this->postQueryBuilder->getPostsByCriteria($criteria)
            ->paginate($page = $criteria->pageNumber, $maxPerPage = $criteria->recordsOnPage);
        $transferPosts = [];
        foreach ($qPosts as $qPost) {
            array_push($transferPosts, $postMapper->mapToTransfer($qPost));
        }

        return $transferPosts;
    }

    public function getPostById(int $postId): PostTransferObject {
        $postMapper = new PostEntityMapper();
        $qPost = $this->postQueryBuilder->getPostById($postId)->find();
        return $postMapper->mapToTransfer($qPost[0]);
    }

    public function savePost(PostTransferObject $blogPost): void
    {
        if (is_numeric($blogPost->id)) {
            $newPost = PostQuery::create()
                ->findPk($blogPost->id);
        } else {
            $newPost = new Post();
        }
        $newPost->setMessage($blogPost->message);
        $newPost->setTags(new Collection());
        foreach ($blogPost->tags as $tagTitle) {
            $postTag = TagQuery::create()
                ->filterByTitle($tagTitle)
                ->findOneOrCreate();
            $newPost->addTag($postTag);
        }

        $newPost->save();
    }

    public function createPostComment(PostCommentTransferObject $comment)
    {
        $newPostComment = new Comment();
        $newPostComment->setPostId($comment->postId);
        $newPostComment->setText($comment->text);
        $newPostComment->save();
    }

    /**
     * @param int $postId
     * @return PostCommentTransferObject[]
     */
    public function getPostComments(int $postId): array
    {
        $commentMapper = new PostCommentEntityMapper();
        $qPostComments = $this->postQueryBuilder->getPostComments($postId);
        $postComments = [];
        foreach ($qPostComments as $qPostComment) {
            array_push($postComments, $commentMapper->mapToTransfer($qPostComment));
        }

        return $postComments;
    }
}