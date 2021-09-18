<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/create")
    */


    public function create(): void
    {
        //dd($_SERVER);
        dd($_REQUEST);
        //dd($_POST);
        //dd($GLOBALS['_REQUEST']);
    }
}
