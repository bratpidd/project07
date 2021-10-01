<?php

namespace App\Services\PostService\TransferObjectsMappers;

use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;

class PostCommentEntityMapper
{

    public function mapToTransfer($qPostComment): PostCommentTransferObject {
        return new PostCommentTransferObject($qPostComment->getText(), $qPostComment->getPostId(), $qPostComment->getId());
    }

}