<?php

namespace Demo\Domain\Email\SendToAdminNotify;

use Demo\Domain\Base\DomainCommand;
use Demo\Domain\Task\Task;

class SendToAdminNotifyCommand extends DomainCommand
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