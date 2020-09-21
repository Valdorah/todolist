<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Todo;
use App\Form\TodoType;

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

    /**
     * @Route("/todo/add", name="add-todo")
     */
    public function addTodo(Request $request){
        $todo = new Todo();

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo = $form->getData();

            $todo->setCreatedAt(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('todo/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
