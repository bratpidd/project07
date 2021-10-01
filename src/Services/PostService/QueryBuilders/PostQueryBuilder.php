<?php

namespace App\Services\PostService\QueryBuilders;

use App\Services\PostService\Persistence\Propel\Comment;
use App\Services\PostService\Persistence\Propel\CommentQuery;
use App\Services\PostService\Persistence\Propel\Post;
use App\Services\PostService\Persistence\Propel\PostQuery;
use App\Services\PostService\Persistence\Propel\TagQuery;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;
use Propel\Runtime\Collection\Collection;

class PostQueryBuilder
{

    public function getPostsByCriteria(SearchCriteria $criteria): PostQuery
    {
        $qPosts = PostQuery::create();
        if (strlen($criteria->filterByTag)) {
            $qPosts = $qPosts
                ->usePostTagQuery()
                    ->useTagQuery()
                        ->filterByTitle($criteria->filterByTag)
                    ->endUse()
                ->endUse();
        }

        return $qPosts->orderByMessage($criteria->sortOrder);
    }

    public function getPostById(int $postId): PostQuery {
        return PostQuery::create()
            ->filterById($postId);
    }

    public function getPostComments(int $postId): CommentQuery {
        return CommentQuery::create()
            ->filterByPostId($postId);
    }

}