<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Todo;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $todos = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findBy([], ['deadline' => 'asc']);

        return $this->render('home/index.html.twig', [
            'todos' => $todos
        ]);
    }
}
