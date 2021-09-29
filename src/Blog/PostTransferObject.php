<?php

namespace App\Blog;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostTransferObject
{
    static function serializeBlogPost(BlogPost $blogPost): string {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);

        return $serializer->serialize($blogPost, 'json');
    }
}