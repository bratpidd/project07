<?php
namespace App\Controller;

use App\Blog\BlogPost;
use App\Blog\BlogPostComment;
use App\Blog\PostQueryBuilder;
use App\Blog\SearchCriteria;
use App\Services\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("/post/edit/{post_id}", name="edit_post", requirements={"post_id"="\d+"})
     * @Route("/post/new", name="new_post")
     */

    public function editPost(Request $request, PostServiceInterface $postService, ?int $post_id): Response {
        if ($request->attributes->get('_route') === "edit_post") {
            $pageTitle = "Edit Post";
            $post = $postService->getPost($post_id);
        } else {
            $pageTitle = "Create New Post";
            $post = new BlogPost('Write A Blog Post', ['example tag 1', 'example tag 2']);
        }

        $form = $this->createFormBuilder($post)
            ->add('message', TextareaType::class, ['label' => false, 'attr' => ['rows' => 5]])
            ->add('tags', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Post'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedPost = $form->getData();
            if ($request->attributes->get('_route') === "edit_post") {
                $postService->updatePost($submittedPost);
            } else {
                $postService->createPost($submittedPost->message, $submittedPost->tags);
            }

            return $this->redirectToRoute('observe_posts');
        }

        return $this->renderForm('post/postEdit.twig', [
            'form' => $form,
            'pageTitle' => $pageTitle
        ]);
    }


    /**
     * @Route("/posts", name="observe_posts")
     */
    public function getPosts(Request $request, PostServiceInterface $postService): Response {
        $criteria = new SearchCriteria();

        $form = $this->createFormBuilder($criteria)
            ->add('sortOrder', ChoiceType::class, ['choices' => ['ASC' => 'ASC', 'DESC' => 'DESC']])
            ->add('filterByTag', TextType::class, ['required' => false])
            ->add('recordsOnPage', NumberType::class)
            ->add('pageNumber', NumberType::class)
            ->add('Search', SubmitType::class, ['label' => 'Search Posts'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedCriteria = $form->getData();
            $posts = $postService->getPosts($submittedCriteria);
        }

        return $this->renderForm('post/postsObserve.twig', ['form' => $form, 'posts' => $posts ?? []]);
    }

    /**
     * @Route("/post/{post_id}", name="view_post", requirements={"post_id"="\d+"})
     */
    public function viewPost(Request $request, int $post_id, PostServiceInterface $postService): Response {
        $post = $postService->getPost($post_id);

        $blogPostComment = new BlogPostComment("Write Comment Here", $post_id);

        $form = $this->createFormBuilder($blogPostComment)
            ->add('text', TextareaType::class, ['label' => false, 'attr' => ['rows' => 5]])
            ->add('save', SubmitType::class, ['label' => 'Add Comment'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedComment = $form->getData();
            PostQueryBuilder::createPostComment($submittedComment);
        }

        $comments = $postService->getPostComments($post->id);

        return $this->renderForm('post/postView.twig', [
            'post' => $post,
            'form' => $form,
            'comments' => $comments
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
