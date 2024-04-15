<?php

namespace App\Model\View;

class TasksListView
{
    public function __construct(
        /** @var list<TaskView> */
        public array $tasks,
    ) {
    }
}