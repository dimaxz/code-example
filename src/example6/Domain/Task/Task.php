<?php

namespace Demo\Domain\Task;

class Task
{
    private $name;

    private $id;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = time();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    public function save(){

    }
}