<?php

namespace App\Services\PostService\Persistence\Repository;

use App\Services\PostService\Persistence\QueryBuilders\PostQueryBuilder;
use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;
use App\Services\PostService\TransferObjectsMappers\PostCommentEntityMapper;
use App\Services\PostService\TransferObjectsMappers\PostEntityMapper;

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
            $transferPosts[] = $postMapper->mapToTransfer($qPost);
        }

        return $transferPosts;
    }

    public function getPostById(int $postId): ?PostTransferObject {
        $postMapper = new PostEntityMapper();
        $qPost = $this->postQueryBuilder->getPostById($postId)->findOne();
        if ($qPost === null) {
            return null;
        }

        return $postMapper->mapToTransfer($qPost);
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
            $postComments[] = $commentMapper->mapToTransfer($qPostComment);
        }

        return $postComments;
    }
}