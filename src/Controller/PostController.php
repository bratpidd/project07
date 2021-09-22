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
        $testValue = "abcd";
		return $truePostService->addPost($request->request->get('message') ?? "izvenite vi zabili message");
	}


	/**
	 * @Route("/post/create2")
	 */

	public function create2(Request $request, PostServiceInterface $postService): Response
	{
        $testDbValue = $this->getTimePostgres();
        dump($testDbValue[0]);
        // phpinfo();
        //xdebug_info();
		return $postService->addPost("(COCATb)");
	}

    public function getTimePostgres()
    {
        $sql = "SELECT now()";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
