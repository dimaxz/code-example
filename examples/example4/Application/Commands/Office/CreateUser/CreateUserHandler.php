<?php


namespace Application\Commands\Office\CreateUser;


use Domain\User\UserEntity;
use Domain\User\UserService;

class CreateUserHandler
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param CreateUserCommand $command
     */
    public function handle(CreateUserCommand $command): void
    {

        $request = $command->getUserRequest();

        $result = $command->getUserResult();

        $result->setSourceId(
            $this->userService->create(
                (new UserEntity())
                    ->setName($request->getName())
                    ->setEmail($request->getEmail())
            )
        );

    }

}