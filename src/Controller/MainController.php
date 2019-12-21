<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // !!! Response [Symfony\Component\HttpFoundation\]
        return new Response('<h1>Welcome freeCodeCamp!</h1>');

        // Generisano posle kreiranja kontrolera zajedno sa ("/main", name="main")
        //return $this->json([
        //    'message' => 'Welcome to your new controller!',
        //    'path' => 'src/Controller/MainController.php',
        //]);
    }

    /**
     * @Route("/custom/{name?}", name="custom")
     * @param Request $request
     * @return Response
     */
    public function custom(Request $request) {
        dump($request);
        //http://localhost/sfcourse/public/index.php/custom
        return new Response('<h1>Custom page! </h1>');
    }
}
