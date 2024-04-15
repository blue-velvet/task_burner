<?php

namespace App\Controller\Cabinet;

use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
