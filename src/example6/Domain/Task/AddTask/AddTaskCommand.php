<?php

namespace Demo\Domain\Task\AddTask;

use Demo\Domain\Base\DomainCommand;

class AddTaskCommand extends DomainCommand
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}