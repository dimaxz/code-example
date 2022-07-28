<?php


include_once './../vendor/autoload.php';
require_once 'config.php';

$taskService = new \Demo\Domain\Task\TaskService($commandBus, new \Demo\Infrastructure\Repositories\Task\TaskRepository());


$tasks = $taskService->getTaskRepository()->findByCriteria(
    new \Demo\Infrastructure\Repositories\Task\TaskSearchCriteria()
);

$taskService->addTask(new \Demo\Domain\Task\AddTask\AddTaskCommand('Тестовая задача 1'));


echo 'work';