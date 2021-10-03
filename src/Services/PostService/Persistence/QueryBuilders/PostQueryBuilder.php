<?php

namespace App\Services\PostService\Persistence\QueryBuilders;

use App\Services\PostService\Persistence\Propel\Comment;
use App\Services\PostService\Persistence\Propel\CommentQuery;
use App\Services\PostService\Persistence\Propel\Post;
use App\Services\PostService\Persistence\Propel\PostQuery;
use App\Services\PostService\Persistence\Propel\TagQuery;
use App\Services\PostService\TransferObjects\PostCommentTransferObject;
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

    public function createPostComment(PostCommentTransferObject $comment)
    {
        $newPostComment = new Comment();
        $newPostComment->setPostId($comment->postId);
        $newPostComment->setText($comment->text);
        $newPostComment->save();
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

}