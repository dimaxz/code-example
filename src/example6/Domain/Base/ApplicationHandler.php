<?php

namespace Demo\Domain\Base;

use BornFree\TacticianDomainEvent\Recorder\RecordsEvents;

abstract class ApplicationHandler
{
    protected $recordsEvents;

    public function __construct(RecordsEvents $recordsEvents)
    {
        $this->recordsEvents = $recordsEvents;
    }

    abstract public function handle(ApplicationCommandInterface $command): void;
}