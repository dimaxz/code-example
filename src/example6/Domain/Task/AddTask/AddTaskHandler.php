<?php

namespace Demo\Domain\Task\AddTask;

use Demo\Domain\Base\ApplicationCommandInterface;
use Demo\Domain\Base\ApplicationHandler;

class AddTaskHandler extends ApplicationHandler
{

    public function handle(ApplicationCommandInterface $command): void
    {
        if(rand(1,2)===2){
            throw new \RuntimeException('error command');
        }


        $task = new \Demo\Domain\Task\Task('Finish review');
        $task->save();

        dump('task create '. $task->getName());

        $this->recordsEvents->record(new TaskWasCreated($task));
    }
}