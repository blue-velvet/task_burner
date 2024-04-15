<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\CreateTaskFormType;
use App\Model\CreateTaskRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route(path: '/api/tasks', methods: [Request::METHOD_POST])]
    public function createTask(
        #[MapRequestPayload] CreateTaskRequest $request,
        EntityManagerInterface $entityManager,
    )
    {
        $form = $this->createForm(CreateTaskFormType::class, $request);
        dump($form->getData());die;
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return new Response('bad request', Response::HTTP_BAD_REQUEST);
        }

        $task = new Task(
            $createTaskRequest->name,
            $createTaskRequest->createdBy
        );
        $entityManager->persist($task);
        $entityManager->flush();
    }
}