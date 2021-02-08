<?php
include_once __DIR__. '../../../vendor/autoload.php';

$controller = new \Demo4\Infrastructure\Controllers\UserController(
        new \Demo4\Infrastructure\Repositories\User\UserRepository(),
    new spaceonfire\CommandBus\CommandBus(
        new \spaceonfire\CommandBus\Mapping\MapByStaticList([
            \Demo4\Application\Commands\Registration\RegistrationUser\RegistrationUserCommand::class => [\Demo4\Application\Commands\Registration\RegistrationUser\RegistrationUserHandler::class,'handle']
        ])
    )

);


dump(
    $controller->show(1)
);


dump(
    $controller->create([
        'email' => 'test@mail.ru',
        'name'  =>  'blabla'
    ])
);