<?php

namespace App\Services\PostService\TransferObjects;

class PostCommentTransferObject
{
    public $text = "";
    /**
     * @var int
     */
    public $postId = null;
    /**
     * @var int
     */
    public $id = null;

    public function __construct(string $text, int $postId, int $id = null) {
        $this->setText($text);
        $this->setPostId($postId);
        if (is_numeric($id)) {
            $this->setId($id);
        }
    }

    public function setText(string $text): void {
        $this->text = $text;
    }

    public function setPostId(int $postId): void {
        $this->postId = $postId;
    }

    public function setId(int $id) {
        $this->id = $id;
    }
}