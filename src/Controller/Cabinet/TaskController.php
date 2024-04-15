<?php

namespace App\Controller\Cabinet;

use App\Entity\Task;
use App\Form\CreateTaskFromCabinetFormType;
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TaskController extends AbstractController
{
    public function __construct(private TaskService $taskService)
    {
    }

    #[Route('/tasks', name: 'app_tasks')]
    public function index(
        #[CurrentUser] $user
    ): Response
    {
        $activeTasks = $this->taskService->findActiveTasksByUser($user);

        return $this->render('task/index.html.twig', [
            'activeTasks' => $activeTasks->tasks,
        ]);
    }

    #[Route('/create-task', name: 'app_create_task')]
    public function createTask(
        #[CurrentUser] $user,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $task = new Task('', $user);
        $form = $this->createForm(CreateTaskFromCabinetFormType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_tasks');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
