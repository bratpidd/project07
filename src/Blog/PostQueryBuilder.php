<?php

namespace App\Blog;

use App\PropelModels\Comment;
use App\PropelModels\CommentQuery;
use App\PropelModels\Post;
use App\PropelModels\PostQuery;
use App\PropelModels\TagQuery;
use Propel\Runtime\Collection\Collection;

class PostQueryBuilder
{

    public function getPostsByCriteria(SearchCriteria $criteria) {
        $qPosts = PostQuery::create();
        if (strlen($criteria->filterByTag)) {
            $qPosts = $qPosts
                ->usePostTagQuery()
                    ->useTagQuery()
                        ->filterByTitle($criteria->filterByTag)
                    ->endUse()
                ->endUse();
        }
        $qPosts = $qPosts
            ->orderByMessage($criteria->sortOrder)
            ->paginate($page = $criteria->pageNumber, $maxPerPage = $criteria->recordsOnPage);

        $posts = [];
        foreach ($qPosts as $qFoundPost) {
            array_push($posts, $this->fromQueryPost($qFoundPost));
        }

        return $posts;
    }

    public function getPostById(int $postId): BlogPost {
        $qPost = PostQuery::create()
            ->findPk($postId);

        return $this->fromQueryPost($qPost);
    }

    /**
     * @param int $postId
     * @return BlogPostComment[]
     */
    public static function getPostComments(int $postId): array {
        $qPostComments = CommentQuery::create()
            ->filterByPostId($postId)
            ->find();
        $postComments = [];
        foreach ($qPostComments as $qPostComment) {
            $postComment = new BlogPostComment($qPostComment->getText(), $qPostComment->getPostId(), $qPostComment->getId());
            array_push($postComments, $postComment);
        }

        return $postComments;
    }


    public static function createPostComment(BlogPostComment $comment): void {
        $newPostComment = new Comment();
        $newPostComment->setPostId($comment->postId);
        $newPostComment->setText($comment->text);
        $newPostComment->save();
    }

    private function fromQueryPost($qPost): BlogPost {
        $tags = [];
        $message = "Post Not Found";

        if (!is_null($qPost)) {
            $message = $qPost->getMessage();
            foreach($qPost->getTags() as $tag) {
                array_push($tags, $tag->getTitle());
            }
        }
        $blogPost = new BlogPost($message, $tags);
        $blogPost->setId($qPost->getId());

        return $blogPost;
    }

    public function savePost(BlogPost $blogPost) {
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