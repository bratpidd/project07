<?php
namespace App\Services;


use App\PropelModels\Post;
use App\PropelModels\Tag;
use App\PropelModels\TagQuery;

class PostService implements PostServiceInterface {

    public function createPost(string $message, array $tags) {
        $post = new Post();
        $post->setMessage($message);

        foreach ($tags as $tagName) {
            $tag = TagQuery::create()
                ->filterByTitle($tagName)
                ->findOneOrCreate();

            $post->addTag($tag);
        }

        $post->save();

        // dd("Regular service was called! , " . $message);
    }

}