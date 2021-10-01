<?php

namespace App\Services\PostService\TransferObjects;

use Exception;
use http\Exception\InvalidArgumentException;

class PostTransferObject implements \Serializable
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
                throw new InvalidArgumentException("Tag passed to setTags is not a string");
            }
        }

        $this->tags = $tags;
    }

    public function setId(int $postId) {
        $this->id = $postId;
    }

    public function serialize(): string
    {
        return json_encode($this);
    }

    public function unserialize($data)
    {
        $objectData = json_decode($data);
        $this->setMessage($objectData->message);
        $this->setTags($objectData->tags);
        $this->setId($objectData->id ?? null);
    }
}