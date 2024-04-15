<?php

namespace App\Service;

use App\Entity\User;
use App\Model\View\TasksListView;
use App\Model\View\TaskView;
use App\Repository\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function findActiveTasksByUser(User $user): TasksListView
    {
        $activeTasksViews = [];

        $activeTasks = $this->taskRepository->findActiveTasksByUser($user);

        foreach ($activeTasks as $activeTask) {
            $activeTasksViews[] = new TaskView(
                $activeTask->getName(),
                $activeTask->getDescription(),
                $activeTask->getPeriod()?->value,
                $activeTask->getCreatedAt()->getTimestamp(),
                $activeTask->getCompletedAt()?->getTimestamp(),
            );
        }

        return new TasksListView($activeTasksViews);
    }
}