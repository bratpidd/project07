<?php

namespace App\Services\PostService;

use App\Services\PostService\Persistence\QueryBuilders\PostQueryBuilder;
use App\Services\PostService\Persistence\Repository\BlogRepository;
use App\Services\RabbitMQ\RabbitMqService;

class PostServiceFactory
{
    public function getBlogRepository(): BlogRepository
    {
        return new BlogRepository();
    }

    public function getPostQueryBuilder(): PostQueryBuilder {
        return new PostQueryBuilder();
    }

    public function getRabbitMqService(): RabbitMqService {
        return new RabbitMqService();
    }

    public function build(): PostService
    {
        $postService = new PostService();
        $postService->factory = $this;
        return $postService;
    }

    /*public function __invoke(): PostService {
        $postService = new PostService();
        $postService->factory = $this;
        return $postService;
    }*/
}