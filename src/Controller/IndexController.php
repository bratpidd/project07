<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="blog_index")
    */


    public function index(Request $request): Response
    {
        $number = random_int(0, 100);
        return new Response(
            $this->renderView("Blog/Pages/mainPage.twig", array(
                "displayValue" => "kek zaga",
                "number" => $number,
                "request" => implode("|", $request->query->all())
            ))
        );
    } 
}
