<?php

namespace App\Model;

use App\Entity\User;

class CreateTaskRequest
{
    public function __construct(
        public string $name,
        public \DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        public ?User $createdBy = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            $this->name,
            $this->createdAt,
            $this->createdBy,
        ];
    }
}