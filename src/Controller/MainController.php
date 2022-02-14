<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/", name="main_home")
     */

    public function home()
    {
     return $this->render('main/home.html.twig');
    }

    /**
     * @Route ("/test", name="main_test")
     */

    public function test()

    {
        {#on peut creer une nouvelle variable et faire appel a elle depuis test.html#}
            $serie = [
                "title" => "GAME OF THRONES",
                "year" => "2010"
            ];

            return $this->render('main/test.html.twig', [
                "mySerie" => $serie,
                "autreVariable" => 'Is N°1'
            ]);
        }
    }
}