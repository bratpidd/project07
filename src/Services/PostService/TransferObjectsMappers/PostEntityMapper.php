<?php

namespace App\Services\PostService\TransferObjectsMappers;

use App\Services\PostService\TransferObjects\PostTransferObject;

class PostEntityMapper
{

/*    public function mapToTransfer($repositoryObject): array
    {
        $posts = [];
        foreach ($repositoryObject as $qFoundPost) {
            array_push($posts, $this->fromQueryPost($qFoundPost));
        }

        return $posts;
    }
*/
    public function mapToTransfer($qPost): PostTransferObject {
        $tags = [];
        $message = "Post Not Found";

        if (!is_null($qPost)) {
            $message = $qPost->getMessage();
            foreach($qPost->getTags() as $tag) {
                array_push($tags, $tag->getTitle());
            }
        }
        $blogPost = new PostTransferObject($message, $tags);
        $blogPost->setId($qPost->getId());

        return $blogPost;
    }


    public function mapToRepository(PostTransferObject $post)
    {

    }
}