<?php

include_once __DIR__.'../../vendor/autoload.php';

$storage = new \Example\MemoryStorage();
$storage->persist([
    'name'  => 'test',
    'email' =>	'test@email.ru',
    'code'  =>  '123',
    'id'    =>	1
]);
$storage->persist([
    'name'  => 'dima',
    'email' =>	'dim@email.ru',
    'code'  =>  'sabhj637',
    'id'    =>	2
]);

$userRepo = new Example\User\UserRepository(new \Example\User\UserMapper,$storage);

$User = $userRepo->findById(2);

dump($User);
