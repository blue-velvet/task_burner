<?php

namespace App\Model\View;

class TaskView
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $period,
        public int $createdAt,
        public ?int $completedAt,
    ) {
    }
}