<?php

$storage = new \DataMapper\Storage\MemoryStorage();
$storage->insert([
    'name'  => 'test',
    'email' =>	'test@email.ru',
    'code'  =>  '123'
]);
$storage->insert([
    'name'  => 'dima',
    'email' =>	'dim@email.ru',
    'code'  =>  'sabhj637'
]);

$userRepo = new Example\User\UserRepository(new \Example\User\UserMapper,$storage);

$User = $userRepo->findById(2);

dump($User);
