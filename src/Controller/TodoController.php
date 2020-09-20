<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Todo;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo/{id}", name="todo", requirements={"id"="\d+"})
     */
    public function index(int $id)
    {
        $todo = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findOneById($id);

        if(!$todo){
            return $this->redirectToRoute('home');
        }
        
        return $this->render('todo/index.html.twig', [
            'todo' => $todo
        ]);
    }
}
