<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
    */


    public function index(): Response
    {
        $number = random_int(0, 100);
        return new Response(
            $this->renderView("index.twig", array(
                "displayValue" => "kek zaga",
                "number" => $number
            ))
        );
    } 
}
