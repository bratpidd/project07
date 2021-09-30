<?php

namespace App\Blog;

class BlogPost
{
    public $message = "";
    /**
     * @var string[]
     */
    public $tags = [];
    public $id = null;

    public function __construct(string $message = "", array $tags = []) {
        $this->setMessage($message);
        $this->setTags($tags);
    }

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function setTags(array $tags): void {
        foreach ($tags as $tag) {
            if (!is_string($tag)) {
                exit("Tag passed to setTags is not a string");
            }
        }

        $this->tags = $tags;
    }

    public function setId(int $postId) {
        $this->id = $postId;
    }
}