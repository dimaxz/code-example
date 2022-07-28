<?php

namespace Demo\Domain\Task;


use Demo\Domain\Base\DomainService;
use Demo\Domain\Task\AddTask\AddTaskCommand;
use Demo\Domain\Task\Contracts\TaskRepositoryInterface;

class TaskService extends DomainService
{
    private $taskRepository;

    public function __construct($commandBus, TaskRepositoryInterface $taskRepository)
    {
        parent::__construct($commandBus);
        $this->taskRepository = $taskRepository;
    }

    /**
     * @return TaskRepositoryInterface
     */
    public function getTaskRepository(): TaskRepositoryInterface
    {
        return $this->taskRepository;
    }


    public function addTask(AddTaskCommand $command)
    {
        $this->commandBus->handle($command);
    }

}