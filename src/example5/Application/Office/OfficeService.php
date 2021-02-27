<?php


namespace Demo5\Application\Office;


use Demo5\Domain\User\UserEntity;
use Demo5\Infrastructure\Repositories\User\UserRepository;
use League\Tactician\Logger\Tests\Fixtures\RegisterUserCommand;
use spaceonfire\CommandBus\CommandBus;

class OfficeService
{

    /**
     * @var UserRepository
     */
    protected $userRepository;
    protected $authDriver;
    protected $commandBus;

    /**
     * OfficeService constructor.
     * @param UserRepository $userRepository
     * @param Auth $authDriver
     * @param CommandBus $commandBus
     */
    public function __construct(UserRepository $userRepository, Auth $authDriver, CommandBus $commandBus)
    {
        $this->userRepository = $userRepository;
        $this->authDriver = $authDriver;
        $this->commandBus = $commandBus;
    }

    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function getUserById(int $id): ?UserEntity
    {
        if (!$user = $this->userRepository->findById($id)) {
            throw new UserNotFound('user not found by id ' . $id);
        }

        return $user;
    }

    /**
     * @return UserEntity|null
     */
    public function getCurrentUser(): ?UserEntity
    {
        $data = $this->authDriver->getAuthUser();

        if (!$user = $this->userRepository->findById($data['user_id'])) {
            throw new UserNotFound('current user not found');
        }

        return $user;
    }

    /**
     * @param RegisterUserCommand $command
     * @return int
     */
    public function registerUser(RegisterUserCommand $command): int
    {
        $this->commandBus->handle($command);
        //..register event
    }
}