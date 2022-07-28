<?php

namespace Demo\Domain\Base;

abstract class DomainCommand implements ApplicationCommandInterface
{

    protected $uuid;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }


}