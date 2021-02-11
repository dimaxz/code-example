<?php


namespace Demo4\Application\Commands\Registration\RegistrationUser;


use Demo4\Domain\User\Contracts\UserRepositoryInterface;
use Domain\User\UserEntity;
use Domain\User\UserService;

class RegistrationUserHandler
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateUserCommand $command
     */
    public function handle(RegistrationUserCommand $command): void
    {

        $request = $command->getUserRequest();

        $result = $command->getUserResult();

        $result->setSourceId(
            $this->userRepository->save(
                (new UserEntity())
                    ->setName($request->getName())
                    ->setEmail($request->getEmail())
            )
        );

    }

}