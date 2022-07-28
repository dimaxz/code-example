<?php

namespace Demo\Domain\Base;


abstract class DomainService
{
    protected $commandBus;

    function __construct($commandBus)
    {

        $this->commandBus = $commandBus;

    }

}