<?php

namespace Demo\Infrastructure\Repositories\Task;

use Demo\Domain\Task\Contracts\TaskRepositoryInterface;
use Demo\Domain\Task\Contracts\TaskSearchCriteriaInterface;
use Demo\Domain\Task\Task;

class TaskRepository implements TaskRepositoryInterface
{

    public function findByCriteria(TaskSearchCriteriaInterface $criteria): array
    {
        return [
            new Task('test1'),
            new Task('test2')
        ];
    }

}