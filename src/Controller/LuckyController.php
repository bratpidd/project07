<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    /**
     * @Route("/lucky/number1")
    */
    public function number1(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html lang=""><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
