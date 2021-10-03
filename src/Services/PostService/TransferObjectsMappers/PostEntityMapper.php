<?php

namespace App\Services\PostService\TransferObjectsMappers;

use App\Services\PostService\Persistence\Propel\Post;
use App\Services\PostService\TransferObjects\PostTransferObject;

class PostEntityMapper
{
    /**
     * @param Post $qPost
     * @return PostTransferObject
     */
    public function mapToTransfer(Post $qPost): PostTransferObject {
        $blogPost = new PostTransferObject();
        $tags = [];
        foreach($qPost->getTags() as $tag) {
            array_push($tags, $tag->getTitle());
        }
        $blogPost->setMessage($qPost->getMessage());
        $blogPost->setTags($tags);
        $blogPost->setId($qPost->getId());

        return $blogPost;
    }

}