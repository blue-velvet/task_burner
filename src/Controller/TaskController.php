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
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    #[Route(path: '/api/tasks', methods: [Request::METHOD_POST])]
    public function createTask(
        #[CurrentUser] $user,
        #[MapRequestPayload] CreateTaskRequest $createTaskRequest,
        Request $request,
        EntityManagerInterface $entityManager,
    )
    {
        $createTaskRequest->createdBy = $user;
        $form = $this->createForm(CreateTaskFormType::class, $createTaskRequest);
        $form->submit($request->request->all(), false);
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