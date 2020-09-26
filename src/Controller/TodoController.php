<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $user = $this->getUser();

            $todo->setCreatedAt(new \DateTime());
            $todo->setAuthor($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('todo/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/todo/delete/{id}", name="delete-todo", requirements={"id"="\d+"})
     */
    public function deleteTodo(Request $request, int $id){
        if(!$request->isXmlHttpRequest()){
            throw new BadRequestHttpException('Bad request');
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->findOneById($id);

        if($todo){
            $entityManager->remove($todo);
            $entityManager->flush();
        }

        $response = new JsonResponse(null, 204);
        return $response;
    }

    /**
     * @Route("/todo/modify/{id}", name="modify-todo", requirements={"id"="\d+"})
     */
    public function modifyTodo(Request $request, int $id){
        $entityManager = $this->getDoctrine()->getManager();
        
        $todo = $entityManager->getRepository(Todo::class)->findOneById($id);

        if(!$todo){
            throw $this->createNotFoundException("No todo find with id : $id.");
        }
        
        $form = $this->createForm(TodoType::class, $todo);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo = $form->getData();
            
            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('todo', ['id' => $id]);
        }

        return $this->render('todo/modify.html.twig', [
            'form' => $form->createView(),
            'todo' => $todo
        ]);
    }
}
