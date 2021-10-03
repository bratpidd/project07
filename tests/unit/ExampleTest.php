<?php
namespace App\Tests;

use App\Services\PostService\PostServiceInterface;
use App\Services\PostService\TransferObjects\PostCommentTransferObject;
use App\Services\PostService\TransferObjects\PostTransferObject;
use App\Services\PostService\TransferObjects\SearchCriteria;
use Codeception\Specify;
use Codeception\Test\Unit;

// php vendor/bin/codecept run unit ExampleTest
class ExampleTest extends Unit
{
    use Specify;

    /**
     * @var UnitTester
     */
    protected $tester;

    /** @specify
     * @var PostTransferObject
     */
    private $post;

    /**
     * @var PostCommentTransferObject
     */
    private $postComment;

    /**
     * @var PostServiceInterface
     */
    private $postService;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testPostService()
    {
        $this->post = new PostTransferObject("test message", ["tag01", "tag02"]);
        $this->post->setId(123);
        $this->postComment = new PostCommentTransferObject("test comment", 123);
        $testBlogRepository = $this->makeEmpty('App\Services\PostService\Persistence\Repository\BlogRepository', [
            'getPostsByCriteria' => [$this->post],
            'getPostById' => function(int $postId) {
                if ($postId === 0) {
                    return null;
                }
                return $this->post;
            },
            'getPostComments' => [$this->postComment]
        ]);
        $testPostQueryBuilder = $this->makeEmpty('App\Services\PostService\Persistence\QueryBuilders\PostQueryBuilder', [
            'getPostsByCriteria' => []
        ]);
        $testPostServiceFactory = $this->makeEmptyExcept('App\Services\PostService\PostServiceFactory', 'build', [
            'getBlogRepository' => $testBlogRepository,
            'getPostQueryBuilder' => $testPostQueryBuilder
        ]);

        $this->postService = $testPostServiceFactory->build();

        $this->specify('Testing getPost method', function() {
            $this->assertNull($this->postService->getPost(0));
            $this->assertTrue($this->postService->getPost(111) instanceof PostTransferObject);
        });

        $this->specify('Testing getPosts method', function() {
            $criteria = new SearchCriteria();
            $this->assertEquals([$this->post], $this->postService->getPosts($criteria));
        });
        $this->specify('Testing createPost method', function() {
            $this->assertNull($this->postService->createPost("test", []));
        });
        $this->specify('Testing updatePost method', function() {
            $this->assertNull($this->postService->updatePost($this->post));
        });
        $this->specify('Testing importPosts method', function() {
            $importJson = '[{"message": "test", "tags": ["t1", "t2"]}]';
            $this->assertNull($this->postService->importPosts($importJson));
        });
        $this->specify('Testing createPostComment method', function() {
            $this->assertNull($this->postService->createPostComment($this->postComment));
        });
        $this->specify('Testing getPostComments method', function() {
            $this->assertEquals([$this->postComment], $this->postService->getPostComments(123));
        });
    }
}