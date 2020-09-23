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
        $user = $this->getUser();

        $todos = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findBy(['author' => $user->getId()], ['deadline' => 'asc']);

        return $this->render('home/index.html.twig', [
            'todos' => $todos
        ]);
    }
}
