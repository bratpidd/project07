<?php
namespace App\Controller;

use App\Util\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
	/**
	 * @Route("/post/create")
	 */

	public function create(Request $request, PostServiceInterface $truePostService): Response {
		return $truePostService->addPost($request->request->get('message') ?? "izvenite vi zabili message");
	}


	/**
	 * @Route("/post/create2")
	 */

	public function create2(Request $request, PostServiceInterface $postService): Response
	{
        $testVar = "123";
        echo($testVar);
        xdebug_info();
		return $postService->addPost("(COCATb)");
	}

}
