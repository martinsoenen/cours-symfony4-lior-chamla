<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller {

    /**
     * @Route("/bonjour/{prenom}/{age}", name="hello")
     * @Route("/salut", name="hello_base")
     * Montre la page qui dit bonjour
     */
    public function hello($prenom = "anonyme", $age = 0) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        $prenoms = ["Martin" => 20, "Inès" => 19, "Lior" => 31, "Valérie" => 52, "Christophe" => 58];

        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous",
                'age' => 20,
                'tableau' => $prenoms
            ]
        );
    }

}

?>