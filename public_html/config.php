<?php

use Demo\Domain\Task\AddTask\TaskWasCreated;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

error_reporting(-1);
ini_set('display_errors', 1);

$eventRecorder = new \BornFree\TacticianDomainEvent\Recorder\EventRecorder();
$eventDispatcher = new \BornFree\TacticianDomainEvent\EventDispatcher\EventDispatcher();



$releaseRecordedEventsMiddleware = new \BornFree\TacticianDomainEvent\Middleware\ReleaseRecordedEventsMiddleware($eventRecorder, $eventDispatcher);
$commandHandlerMiddleware = new \League\Tactician\Handler\CommandHandlerMiddleware(
    new ClassNameExtractor(),
    new InMemoryLocator([
        \Demo\Domain\Task\AddTask\AddTaskCommand::class => new \Demo\Domain\Task\AddTask\AddTaskHandler($eventRecorder),
        \Demo\Domain\Email\SendToAdminNotify\SendToAdminNotifyCommand::class => new \Demo\Domain\Email\SendToAdminNotify\SendToAdminNotifyHandler($eventRecorder)
    ]),
    new HandleInflector()
);

$eventMiddleware = new \League\Tactician\CommandEvents\EventMiddleware();
$eventMiddleware->addListener(
    'command.handled',
    function (\League\Tactician\CommandEvents\Event\CommandHandled $event) {
        //dump('handled');
    }
);
$eventMiddleware->addListener(
    'command.received',
    function (\League\Tactician\CommandEvents\Event\CommandReceived $event) {
        //dump('received');
    }
);
$eventMiddleware->addListener(
    'command.failed',
    function (\League\Tactician\CommandEvents\Event\CommandFailed $event) {
        //dump('failed');
        $event->catchException(); // without calling this the exception will be thrown
    }
);

$commandBus = new \League\Tactician\CommandBus(
    [
        $eventMiddleware, $releaseRecordedEventsMiddleware, $commandHandlerMiddleware
    ]
);

$emailService = new \Demo\Domain\Email\EmailService($commandBus);

$eventDispatcher->addListener(TaskWasCreated::class , function(TaskWasCreated $event) use ($emailService){
    $emailService->sendToAdminNotify(new \Demo\Domain\Email\SendToAdminNotify\SendToAdminNotifyCommand($event->getTask()));
});