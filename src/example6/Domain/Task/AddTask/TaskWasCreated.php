<?php

namespace Demo\Domain\Task\AddTask;

use Demo\Domain\Task\Task;

class TaskWasCreated
{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }


}