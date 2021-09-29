<?php
namespace App\Controller;

use App\Blog\BlogPost;
use App\Services\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostController extends AbstractController
{
	/**
	 * @Route("/post/create")
	 */

	public function create(Request $request, PostServiceInterface $truePostService): Response {
        $testValue = $this->getParameter('env_value');
        dd(123);
		//return $truePostService->addPost($testValue . ($request->request->get('message') ?? " No message was provided"));
	}


	/**
	 * @Route("/post/create2")
	 */

	public function create2(Request $request, PostServiceInterface $postService): Response
	{
        $testDbValue = $this->getTimePostgres();
        dump($testDbValue[0]);
        // phpinfo();
        // xdebug_info();
        dd(123);
		//return $postService->addPost("(msg)");
	}

    /**
     * @Route("/post/getPostById/{post_id}", name="post_by_id", requirements={"post_id"="\d+"})
     */

    public function getPostById(int $post_id, PostServiceInterface $postService) {
        $blogPost = new BlogPost();
        $blogPost->setMessage('Write A Blog Post');
        $blogPost->setTags(['exTag_1', 'exTag_2']);

        $post = $postService->getPost($post_id);

        $form = $this->createFormBuilder($post)
            ->add('message', TextType::class)
            ->add('tags', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Post'])
            ->getForm();

        return $this->renderForm('post/post_01.twig', [
            'form' => $form
        ]);
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
