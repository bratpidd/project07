<?php

namespace App\Blog;

use App\PropelModels\Post;
use App\PropelModels\PostQuery;
use App\PropelModels\TagQuery;

class PostQueryBuilder
{

    public function buildPropelQuery(SearchCriteria $criteria) {
        $posts = PostQuery::create()
            ->usePostTagQuery()
                ->useTagQuery()
                    ->filterByTitle($criteria->filterByTag)
                ->endUse()
            ->endUse()
            ->orderByMessage($criteria->sortOrder)
            ->paginate($page = $criteria->pageNumber, $maxPerPage = $criteria->recordsOnPage);

        return $posts;
    }

    public function getPostById(int $postId): BlogPost {
        $qPost = PostQuery::create()
            ->findPk($postId);

        $tags = [];
        $message = "Post Not Found";

        if (!is_null($qPost)) {
            $message = $qPost->getMessage();
            foreach($qPost->getTags() as $tag) {
                array_push($tags, $tag->getTitle());
            }
        }

        return new BlogPost($message, $tags);
    }

    public function createPost(BlogPost $blogPost) {
        $newPost = new Post();
        $newPost->setMessage($blogPost->message);

        foreach ($blogPost->tags as $tagTitle) {
            $postTag = TagQuery::create()
                ->filterByTitle($tagTitle)
                ->findOneOrCreate();
            $newPost->addTag($postTag);
        }

        $newPost->save();
    }

}